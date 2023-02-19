<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upload', function (\Illuminate\Http\Request $request) {
    $kml = '<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2"><Document><name> Location history from 2023-02-07 to 2023-02-07 </name><open>1</open><description></description><StyleMap id="multiTrack"><Pair><key>normal</key><styleUrl>#multiTrack_n</styleUrl></Pair><Pair><key>highlight</key><styleUrl>#multiTrack_h</styleUrl></Pair></StyleMap><Style id="multiTrack_n"><IconStyle><Icon><href>https://earth.google.com/images/kml-icons/track-directional/track-0.png</href></Icon></IconStyle><LineStyle><color>99ffac59</color><width>6</width></LineStyle></Style><Style id="multiTrack_h"><IconStyle><scale>1.2</scale><Icon><href>https://earth.google.com/images/kml-icons/track-directional/track-0.png</href></Icon></IconStyle><LineStyle><color>99ffac59</color><width>8</width></LineStyle></Style>results</Document></kml>';

    $files = $request->file('files');
    $pattern = '@<Placemark>(.*)</Placemark>@';
    $results = '';

    array_shift($files);

    foreach ($files as $file) {
        $match = null;
        preg_match_all($pattern, $file->get(), $match);
        $place = $match[0][0];

        $results .= $place;
    }

    file_put_contents('kml', str_replace('results', $results, $kml));
})->name('upload');
