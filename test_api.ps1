$body = @{
    jenis_ujian = 'uts'
    nama = 'Test Student'
    sekolah = 'smk1'
    token = '232021'
} | ConvertTo-Json

$response = Invoke-WebRequest -Uri 'http://127.0.0.1:8000/api/test/start' -Method POST -Headers @{'Content-Type'='application/json'} -Body $body -SessionVariable sess

$data = $response.Content | ConvertFrom-Json
$sessionToken = $data.session_token

Write-Host "Session Token: $sessionToken"
Write-Host "Start Response Success: $($data.success)"

# Test questions endpoint
$questionsResponse = Invoke-WebRequest -Uri 'http://127.0.0.1:8000/api/test/questions' -Headers @{'X-Session-Token'=$sessionToken} -WebSession $sess

$questionsData = $questionsResponse.Content | ConvertFrom-Json
Write-Host "Questions Count: $($questionsData.questions.Count)"
Write-Host "First Question: $($questionsData.questions[0].question_text)"
Write-Host "First Question Options: $($questionsData.questions[0].options -join ', ')"
Write-Host "Time Left: $($questionsData.time_left) seconds"
