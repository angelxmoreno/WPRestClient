<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

use GuzzleHttp\Psr7\Request;
use WPRestClient\Auth\BasicAuth;

describe(BasicAuth::class, function () {
    describe('setters/getters', function () {
        it('sets and gets username and password', function () {
            $auth = new BasicAuth('user1', 'pwd1');
            expect($auth->getUsername())->toBe('user1');
            expect($auth->getPassword())->toBe('pwd1');

            expect($auth)->toReceive('setUsername')->with('user2');
            expect($auth)->toReceive('setPassword')->with('pwd2');
            $auth->setUsername('user2');
            $auth->setPassword('pwd2');
            expect($auth->getUsername())->toBe('user2');
            expect($auth->getPassword())->toBe('pwd2');
        });
    });

    describe('->withAuth()', function () {
        it('augments a request', function () {
            $request = new Request('get', '/users', [
                'Authorization' => 'value1',
            ]);
            $expected = 'Basic ' . base64_encode('user1:pwd1');
            $auth = new BasicAuth('user1', 'pwd1');
            $requestWithAuth = $auth->withAuth($request);
            expect($requestWithAuth->getHeaderLine('Authorization'))->toBe($expected);
        });
    });
});
