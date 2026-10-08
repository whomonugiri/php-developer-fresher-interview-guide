<?php
declare(strict_types=1);
/** Run only against the documented localhost server. No curl/Composer dependency. */
$base = $argv[1] ?? 'http://127.0.0.1:8002';
if (preg_match('~\Ahttp://(?:127\.0\.0\.1|localhost):[0-9]+\z~', $base) !== 1) {
    fwrite(STDERR, "Use an explicit localhost URL, e.g. http://127.0.0.1:8002\n");
    exit(2);
}
if (!filter_var(ini_get('allow_url_fopen'), FILTER_VALIDATE_BOOLEAN)) {
    fwrite(STDERR, "This HTTP test needs allow_url_fopen enabled for localhost streams.\n");
    exit(2);
}
$cookie = '';
$passed = 0;
$failed = 0;
$createdUpload = null;
function check(bool $ok, string $label): void
{
    global $passed, $failed;
    if ($ok) { ++$passed; }
    else { ++$failed; fwrite(STDERR, "FAIL: $label\n"); }
}
function request(string $path, string $method = 'GET', array|string $data = [], array $extraHeaders = []): array
{
    global $base, $cookie;
    $headers = ['Connection: close'];
    if ($cookie !== '') { $headers[] = 'Cookie: ' . $cookie; }
    $body = is_array($data) ? http_build_query($data) : $data;
    if ($method === 'POST' && is_array($data)) { $headers[] = 'Content-Type: application/x-www-form-urlencoded'; }
    $headers = array_merge($headers, $extraHeaders);
    $options = ['method' => $method, 'header' => implode("\r\n", $headers),
        'ignore_errors' => true, 'follow_location' => 0, 'timeout' => 10];
    if ($method === 'POST') { $options['content'] = $body; }
    $http_response_header = [];
    $result = file_get_contents($base . $path, false, stream_context_create(['http' => $options]));
    if ($result === false) { throw new RuntimeException('Cannot reach the localhost test server. Start it first.'); }
    $status = 0;
    foreach ($http_response_header as $header) {
        if (preg_match('~\AHTTP/\S+ ([0-9]+)~', $header, $match)) { $status = (int) $match[1]; }
        if (preg_match('~\ASet-Cookie: (part2_demo=[^;]+)~i', $header, $match)) { $cookie = $match[1]; }
    }
    return ['status' => $status, 'body' => $result, 'headers' => $http_response_header];
}
function tokenFrom(array $response): string
{
    if (preg_match('/name="csrf" value="([a-f0-9]{64})"/', $response['body'], $match) !== 1) {
        throw new RuntimeException('The form did not contain a CSRF token.');
    }
    return $match[1];
}
function post(string $path, array $data): array
{
    $token = tokenFrom(request($path));
    return request($path, 'POST', ['csrf' => $token] + $data);
}
try {
    check(request('/')['status'] === 200, 'index');
    foreach (range(1, 28) as $n) {
        check(request('/Question_' . $n . '.php')['status'] === 200, "Q$n GET");
    }
    check(request('/lib/validation.php')['status'] === 404, 'library source is not routed');
    check(request('/storage/README.md')['status'] === 404, 'private storage is not routed');
    check(request('/lib/topics.json')['status'] === 404, 'topic metadata is not routed');
    check(request('/Question_29.php')['status'] === 404, 'unknown lesson is not routed');
    check(request('/', 'GET', [], ['Host: attacker.invalid'])['status'] === 403, 'unexpected Host rejected');
    check(request('/Question_19.php', 'PUT')['status'] === 405, 'unsupported method rejected');
    check(request('/Question_19.php', 'POST', ['student_name' => 'Aman'])['status'] === 403, 'missing CSRF rejected');
    check(request('/Question_19.php', 'POST', ['csrf' => ['bad'], 'student_name' => 'Aman'])['status'] === 403, 'array CSRF rejected');
    check(post('/Question_19.php', ['student_name' => '  '])['status'] === 422, 'blank name');
    check(post('/Question_19.php', ['student_name' => ['Aman']])['status'] === 422, 'array name');
    $r = post('/Question_19.php', ['student_name' => '<script>alert(1)</script>']);
    check($r['status'] === 200 && str_contains($r['body'], '&lt;script&gt;alert(1)&lt;/script&gt;')
        && !str_contains($r['body'], '<script>'), 'name HTML escaping');
    check(request('/support/question_19/form.html')['status'] === 200, 'legacy static form entry');
    $r = request('/support/question_19/form.php');
    $r = request('/support/question_19/process.php', 'POST', ['csrf' => tokenFrom($r), 'student_name' => 'Aman']);
    check($r['status'] === 200 && str_contains($r['body'], 'Namaste, Aman'), 'separate form processor');
    check(request('/support/question_19/process.php')['status'] === 405, 'processor requires POST');
    check(request('/Question_20.php?q%5B%5D=PHP')['status'] === 422, 'array query');
    $r = request('/Question_20.php?q=%3Cb%3EPHP%3C%2Fb%3E');
    check($r['status'] === 200 && str_contains($r['body'], '&lt;b&gt;PHP&lt;/b&gt;'), 'GET query escaping');
    $r = post('/Question_21.php', ['age' => '0']);
    check($r['status'] === 200 && str_contains($r['body'], 'Validated integer age: 0'), 'POST age accepts zero');
    foreach (['121', '-1', '2.5', ['21']] as $age) {
        check(post('/Question_21.php', ['age' => $age])['status'] === 422, 'POST age rejects invalid value');
    }
    $r = post('/Question_24.php', []);
    check($r['status'] === 200 && str_contains($r['body'], 'Selected skills: (none)'), 'unchecked skills');
    $r = post('/Question_24.php', ['skills' => ['PHP', 'MySQL', 'PHP']]);
    check($r['status'] === 200 && str_contains($r['body'], 'Selected skills: PHP, MySQL'), 'valid deduplicated skills');
    foreach (['PHP', [['PHP']], ['Rust']] as $skills) {
        check(post('/Question_24.php', ['skills' => $skills])['status'] === 422, 'malformed skills');
    }
    $r = post('/Question_25.php', ['name' => 'A "quoted" name', 'email' => 'bad', 'course' => 'php']);
    check($r['status'] === 422 && str_contains($r['body'], 'value="A &quot;quoted&quot; name"')
        && str_contains($r['body'], 'value="php" selected'), 'sticky error values are escaped and selected');
    $r = post('/Question_25.php', ['name' => 'Aman', 'email' => 'a@example.com', 'course' => 'php']);
    check($r['status'] === 200 && str_contains($r['body'], 'Validated only; nothing saved.'), 'valid enquiry');
    check(post('/Question_25.php', ['name' => [], 'email' => [], 'course' => []])['status'] === 422, 'enquiry arrays rejected');
    $r = post('/Question_28.php', ['course' => 'php', 'fee' => '1', 'coupon' => 'FREE']);
    check($r['status'] === 200 && str_contains($r['body'], 'Server course fee: ₹2500'), 'tampered price ignored');
    check(post('/Question_28.php', ['course' => 'unknown'])['status'] === 422, 'unknown price key rejected');
    $r = post('/Question_27.php', ['name' => 'Aman']);
    check($r['status'] === 303 && in_array('Location: /support/question_27/thank-you.php', $r['headers'], true), 'PRG redirects with 303');
    $r = request('/support/question_27/thank-you.php');
    check($r['status'] === 200 && str_contains($r['body'], 'Namaste, Aman'), 'PRG flash greeting');
    $r = request('/support/question_27/thank-you.php');
    check($r['status'] === 200 && str_contains($r['body'], 'No new submission'), 'PRG refresh consumes no second POST');
    check(request('/support/question_27/prg.php')['status'] === 200, 'legacy PRG entry');
    check(post('/Question_26.php', [])['status'] === 422, 'missing upload rejected');
    if (class_exists('finfo')) {
        $token = tokenFrom(request('/Question_26.php'));
        $boundary = 'Part2Test' . bin2hex(random_bytes(8));
        $pdf = "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\ntrailer\n<< /Root 1 0 R >>\n%%EOF\n";
        $body = '--' . $boundary . "\r\nContent-Disposition: form-data; name=\"csrf\"\r\n\r\n" . $token . "\r\n"
            . '--' . $boundary . "\r\nContent-Disposition: form-data; name=\"resume\"; filename=\"../../unsafe.php\"\r\n"
            . "Content-Type: application/x-php\r\n\r\n" . $pdf . "\r\n--" . $boundary . "--\r\n";
        $r = request('/Question_26.php', 'POST', $body, ['Content-Type: multipart/form-data; boundary=' . $boundary]);
        $saved = preg_match('/Saved privately as ([a-f0-9]{32}\.pdf)/', $r['body'], $match) === 1;
        check($r['status'] === 200 && $saved, 'PDF uses server MIME and random name');
        if ($saved) {
            $createdUpload = dirname(__DIR__) . '/storage/uploads/' . $match[1];
            check(is_file($createdUpload), 'uploaded file moved outside public');
            check(request('/storage/uploads/' . $match[1])['status'] === 404, 'uploaded file cannot be downloaded');
            if (DIRECTORY_SEPARATOR === '/') {
                check((fileperms($createdUpload) & 0777) === 0600, 'upload permissions are private');
            }
        }
        $body = str_replace($pdf, 'this is plain text, not a PDF', $body);
        $r = request('/Question_26.php', 'POST', $body, ['Content-Type: multipart/form-data; boundary=' . $boundary]);
        check($r['status'] === 422, 'non-PDF MIME rejected');
    } else {
        echo "SKIP: real multipart upload needs Fileinfo in the CLI and server runtimes.\n";
    }
} catch (Throwable $error) {
    ++$failed;
    fwrite(STDERR, 'ERROR: ' . $error->getMessage() . "\n");
} finally {
    if ($createdUpload !== null && is_file($createdUpload)) { unlink($createdUpload); }
}
echo "$passed passed, $failed failed\n";
exit($failed === 0 ? 0 : 1);
