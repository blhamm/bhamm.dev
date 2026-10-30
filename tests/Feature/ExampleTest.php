<?php

it('returns a welcome page', function () {
    $response = $this->get('/');

    $response->assertSee("Hey, I'm Brandon.", false);
    $response->assertSee('Ship It!', false);
    $response->assertSee('https://dev-null.sh/@blhamm');
    $response->assertSee('dev/null');
    $response->assertSee('viewBox="1.6 1.5 45 45"', false);
    $response->assertDontSee('pinkary.com');

    $response->assertStatus(200);
});
