<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Vou criar um grupo de rotas para eu proteger
Route::group(['middleware' => 'auth:api'], function (){
    Route::get('products', function(){
        $products =  \App\Product::all();
        return \App\Http\Resources\ProductResource::collection($products);
    });
        Route::get('products/{product}', function(\App\Product $product){
            return new \App\Http\Resources\ProductResource($product);        
    });      

});

Route::post('login', function (Request $request) {
    // pegando alguns dados da request
    $data = $request->only('email', 'password');
    // pegar o token
    // Isso pode ser colocado num controller
    // Aqui ele está falando para o vigia olhar o driver da api,
    // que foi configurado em config/auth.php
    $token = \Auth::guard('api')->attempt($data);
    // se login não tiver sucesso, $token será false
    if (!$token) {
        return response()->json([
        'error' => 'Credentials Invalid'
      ], 400);
    }
    return ['token' => $token];
});


// Para autenticar via api pode ser com auth2 ou JWT
// http://github.com/tymondesigns/jwt-auth
// 1a pegadinha: pegar última versão dela
// ir em commits e pegar o ultimo commit feito
// no terminal digitar
// > composer require tymon/jwt-auth:dev-develop#8dfa7952bf752ea1867fcb038a92e01e4b0d866 (o hash copiado)
// php artisan jwt:secret => gera a assinatura do token
// jwt-auth secret [3qFhKyI6Mon9aX0yMkkOhMRMdnQGIa2p] set successfully.
// fica em .env na variável JWT_SECRET
// Gerar usuario
// php artisan make:seeder UsersTableSeeder
// Criar o login na rota
// No Postman adicionar no header o Authorization com o token recebido ao acessar a rota login
// Bearer + token
// Empresa (Auth0) para brincar com o token: jwt.io
// Publicar o arquivo de configuração do Provider JWT
// php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
// usar jwt quando for você mesmo que irá consumir seu WS
// usar passaport quando for disponibilizar para terceiros consumir seu WS