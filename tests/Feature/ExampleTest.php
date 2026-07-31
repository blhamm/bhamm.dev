<?php

it('returns a welcome page', function () {
    $response = $this->get('/');

	$response->assertSee("Hey, I'm Brandon.", false);

    $response->assertStatus(200);
});
