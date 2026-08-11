<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('geoip:geocode', ['--max-mind'])->hourly();

Schedule::command('geoip:download')->monthly();

Schedule::command('geoip:geocode')->daily();
