<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class WeChatController extends Controller
{

    public function login(Request $request)
    {
        $code = $request->get('code');
        $app = app('easywechat.mini_app');
        $utils = $app->getUtils();
        $session = $utils->codeToSession($code);

        // 将session_key和openid保存到数据库或缓存中，用于后续的登录验证
        $sessionKey = data_get($session, 'session_key');
        $openId = data_get($session, 'openid');
        if (!$openId)
            return response()->json([
                'code' => self::HTTP_AUTH_ERROR,
                'msg' => '授权错误'
            ]);
        $data = [
            'avatar' => $request->get('avatar'),
            'nike_name' => $request->get('nike_name'),
            'language' => $request->get('language'),
            'province' => $request->get('province'),
            'country' => $request->get('country'),
            'city' => $request->get('city'),
            'gender' => $request->get('gender'),
            'session_key' => $sessionKey,
            'unionid' => data_get($session, 'unionid'),
        ];
        if ($phone = $request->get('phone')) {
            $data['phone'] = $phone;
        }

        $user = User::updateOrCreate([
            'openid' => $openId,
        ], $data);

        $data = Arr::only($user->toArray(), ["avatar", "nike_name", "language", "province", "country", "city", "gender"]);
        $data['token'] = $user->createToken('token')->plainTextToken;
        return response()->json([
            'code' => self::HTTP_OK,
            'msg' => '授权成功',
            'data' => $data
        ]);
    }

    public function decryptedPhone(Request $request)
    {
        $validator = Validator::make($request->only([
            'code',
        ]), [
            'code' => 'required',
        ], [
            'code.required' => 'Code不能为空',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => self::HTTP_REQUEST_ERROR,
                'msg' => $validator->messages()->first(),
            ]);
        }

        $data = $validator->validated();
        $app = app('easywechat.mini_app');
        $r = $app->getClient()->postJson('wxa/business/getuserphonenumber', [
            'code' => $data['code'],
        ]);
        $result = json_decode($r->getContent(), true);
        if (data_get($result, 'errcode') === 0) {
            return response()->json([
                "code" => self::HTTP_OK,
                "data" => data_get($result, 'phone_info'),
                "msg" => "OK",
            ]);
        }
        return response()->json([
            "code" => self::HTTP_AUTH_PHONE_ERROR,
            "msg" => data_get($result, 'errmsg'),
            "data" => data_get($result, 'phone_info'),
        ]);
    }

    public function indexUser(Request $request)
    {
        $user = $request->user();
        if (!$user->enable)
            return response()->json([
                'code' => self::HTTP_AUTH_BLOCK,
                'msg' => 'User get block',
            ]);

        return response()->json([
            'code' => self::HTTP_OK,
            'msg' => 'OK',
            'data' => Arr::only($user->toArray(), ['id', 'name', 'phone', "avatar", "nike_name", "language", "province", "country", "city", "gender"])
        ]);
    }
}
