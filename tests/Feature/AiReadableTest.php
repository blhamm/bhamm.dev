<?php

it('serves llms.txt correctly', function () {
    $response = $this->get('/llms.txt');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');
    $response->assertSee('Brandon Hamm', false);
});

it('serves llms-full.txt correctly', function () {
    $response = $this->get('/llms-full.txt');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');
    $response->assertSee('Full Technical Context', false);
});

it('includes the llms.txt discovery link in head', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('href="/llms.txt"', false);
    $response->assertSee('rel="help"', false);
    $response->assertSee('type="text/markdown"', false);
});

it('negotiates markdown content for AI crawlers', function () {
    $response = $this->withHeaders([
        'Accept' => 'text/markdown',
    ])->get('/');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');
    $response->assertSee('Full Technical Context', false);

    $responseBot = $this->withHeaders([
        'User-Agent' => 'Mozilla/5.0 (compatible; GPTBot/1.0; +https://openai.com/gptbot)',
    ])->get('/');

    $responseBot->assertStatus(200);
    $responseBot->assertHeader('Content-Type', 'text/markdown; charset=UTF-8');
    $responseBot->assertSee('Full Technical Context', false);
});
