<?php

use Illuminate\Support\Facades\Schedule;
use App\Jobs\CheckPriceAlerts;

Schedule::job(new CheckPriceAlerts)->everyMinute();
