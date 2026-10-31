<?php

it('returns a welcome page', function () {
    $response = $this->get('/');

    $response->assertSee("Hey, I'm Brandon.", false);
    $response->assertSee('Ship It!', false);
    $response->assertSee('https://dev-null.sh/@blhamm');
    $response->assertSee('dev/null');
    $response->assertSee('viewBox="1.6 1.5 45 45"', false);
    $response->assertDontSee('pinkary.com');
    $response->assertSee('maskUnits="userSpaceOnUse"', false);
    $response->assertSee('maskContentUnits="userSpaceOnUse"', false);
    $response->assertSee('x="-200"', false);
    $response->assertSee('width="2400"', false);
    $response->assertSee('bg-pale-night-white dark:bg-pale-night-black', false);
    $response->assertSee('class="absolute inset-px overflow-hidden"', false);
    $response->assertSee('class="block h-full w-full overflow-visible"', false);
    $response->assertSee('x-ref="maskText"', false);
    $response->assertSee('pointer-events-none absolute -inset-2 z-10', false);
    $response->assertSee('const maskScale = { value: 16 };', false);
    $response->assertSee('maskText.setAttribute(', false);
    $response->assertSee("'transform'", false);
    $response->assertSee('dy=".35em"', false);
    $response->assertDontSee('scale: 0.96', false);
    $response->assertDontSee('svgOrigin:', false);
    $response->assertDontSee('rounded-[2.5rem]', false);

    $response->assertStatus(200);
});
