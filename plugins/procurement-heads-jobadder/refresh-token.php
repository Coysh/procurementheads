<?php
require_once 'logging.php'; // Ensure logging functions are available

// Check if the current access token has expired
function token_is_expired()
{
	$expiration_time = get_option('jobadder_access_token_expiration', 0);
	return time() >= $expiration_time;
}

// Refresh the access token using a refresh token
function jobadder_refresh_access_token($refresh_token)
{
    $token_url = 'https://id.jobadder.com/connect/token';
    $body = [
        'grant_type'    => 'refresh_token',
        'client_id'     => JOBADDER_CLIENT_ID,
        'client_secret' => JOBADDER_CLIENT_SECRET,
        'refresh_token' => $refresh_token,
    ];

    $response = wp_remote_post($token_url, [
        'body'    => $body,
        'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
        'timeout' => 20,
    ]);

    if (is_wp_error($response)) {
        jobadder_log('Failed to refresh token: ' . $response->get_error_message(), 'error');
        return [];
    }

    $status = wp_remote_retrieve_response_code($response);
    $raw    = wp_remote_retrieve_body($response);
    $data   = json_decode($raw, true);

    if (!is_array($data) || !isset($data['access_token'])) {
        jobadder_log('Refresh token response status: ' . $status, 'error');
        jobadder_log('Refresh token response body: ' . $raw, 'error'); // this will show invalid_grant etc
        jobadder_log('Access token not received in the refresh token response.', 'error');
        return [];
    }

    update_option('jobadder_access_token', $data['access_token']);

    $expires_in = (int)($data['expires_in'] ?? 3600);
    update_option('jobadder_access_token_expiration', time() + $expires_in);

    if (!empty($data['refresh_token'])) {
        update_option('jobadder_refresh_token', $data['refresh_token']);
    }

    jobadder_log('Token refreshed successfully.', 'info');
    return $data;
}
