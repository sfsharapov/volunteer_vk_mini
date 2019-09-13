<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use Google_Service_Sheets_BatchUpdateValuesRequest;

class VolunteerController extends Controller
{
	function getClient()
	{
	    $client = new Google_Client();
	    $client->setApplicationName('Google Sheets API PHP Quickstart');
	    $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
	    $client->setAuthConfig('credentials.json');
	    $client->setAccessType('offline');
	    $client->setPrompt('select_account consent');

	    // Load previously authorized token from a file, if it exists.
	    // The file token.json stores the user's access and refresh tokens, and is
	    // created automatically when the authorization flow completes for the first
	    // time.
	    $tokenPath = 'token.json';
	    if (file_exists($tokenPath)) {
	        $accessToken = json_decode(file_get_contents($tokenPath), true);
	        $client->setAccessToken($accessToken);
	    }

	    // If there is no previous token or it's expired.
	    if ($client->isAccessTokenExpired()) {
	        // Refresh the token if possible, else fetch a new one.
	        if ($client->getRefreshToken()) {
	            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
	        } else {
	            // Request authorization from the user.
	            $authUrl = $client->createAuthUrl();
	            printf("Open the following link in your browser:\n%s\n", $authUrl);
	            print 'Enter verification code: ';
	            $authCode = '4/rAFnr2TzDCs5IBtjwjYs5Fs3BpiRT6-RlmCHo_y_M_8jlHfHKDtjAtg';

	            // Exchange authorization code for an access token.
	            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
	            $client->setAccessToken($accessToken);

	            // Check to see if there was an error.
	            if (array_key_exists('error', $accessToken)) {
	                throw new Exception(join(', ', $accessToken));
	            }
	        }
	        // Save the token to a file.
	        if (!file_exists(dirname($tokenPath))) {
	            mkdir(dirname($tokenPath), 0700, true);
	        }
	        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
	    }
	    return $client;
	}

	public function index()
    {
    	// Get the API client and construct the service object.
		$client = $this->getClient();
		$service = new Google_Service_Sheets($client);

		// Prints the names and majors of students in a sample spreadsheet:
		// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
		$spreadsheetId = '1j7cUS-sjoIvfYUA4k_H1dOS0RU6Kow5Qxy_-vJ61KO8';
		$range = 'DB_VOL!A4:G';
		$response = $service->spreadsheets_values->get($spreadsheetId, $range);
		$values = $response->getValues();

		if (empty($values)) {
		    print "No data found.\n";
		} else {
		    print "Name, Major:\n";
		    foreach ($values as $row) {
		        // Print columns A and E, which correspond to indices 0 and 4.
		        printf("%s, %s\n", $row[0], $row[6]);
		    }
		}
        
        echo "It works Yeah))!";
    }

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	//
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function visitCounter($user)
    {
    	// Get the API client and construct the service object.
		$client = $this->getClient();
		$service = new Google_Service_Sheets($client);

		// Prints the names and majors of students in a sample spreadsheet:
		// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
		$spreadsheetId = '1j7cUS-sjoIvfYUA4k_H1dOS0RU6Kow5Qxy_-vJ61KO8';
		$range = 'DB_VOL!A4:G';
		$response = $service->spreadsheets_values->get($spreadsheetId, $range);
		$values = $response->getValues();
		$valueInputOption = "USER_ENTERED";

		if (empty($values)) {
		    print "No data found.\n";
		} else {
		    print "Searching for " .$user .":\n";
		    $cnt = 4;
		    foreach ($values as $row) {
		        // Search column E for the specific user.
		        if (strcasecmp($row[6], $user) == 0) {
		        	$range = "H".$cnt;
		        }
		        //printf("%s, %s\n", $row[0], $row[6]);
		        $cnt++;
		    }
		    echo $range;
		}

		$values = [
		    [
		        "1"// Cell values ...
		    ],
		    // Additional rows ...
		];
		$body = new Google_Service_Sheets_ValueRange([
		    'values' => $values
		]);
		$params = [
		    'valueInputOption' => $valueInputOption
		];
		$result = $service->spreadsheets_values->update($spreadsheetId, $range,
		$body, $params);
		printf("%d cells updated.", $result->getUpdatedCells());
        
        echo "It works Yeah))!";
    }
}
