<?php
declare(strict_types=1);
// Dependency-free tests, independent of php.ini's zend.assertions setting.
define('PART2_TESTING', true);
require_once dirname(__DIR__) . '/lib/validation.php';
$passed = 0;
$failed = 0;
function same(mixed $expected, mixed $actual, string $label): void
{
    global $passed, $failed;
    if ($expected !== $actual) {
        ++$failed;
        fwrite(STDERR, "FAIL: $label\nExpected: " . var_export($expected, true) . "\nActual: " . var_export($actual, true) . "\n");
    } else {
        ++$passed;
    }
}
set_error_handler(static function (int $severity, string $message, string $file, int $line): never {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

// Require actual lesson code in an isolated scope; do not reimplement its operations.
function runLesson(int $number): array
{
    return require dirname(__DIR__) . '/Question_' . $number . '.php';
}
$expectations = [
    1 => ['first_city' => 'Delhi', 'name' => 'Priya', 'second_student' => ['name' => 'Neha', 'marks' => 92], 'key_collision' => [1 => 'second']],
    2 => ['count' => 3, 'preserved_keys' => [1, 2, 3], 'list' => ['Pooja', 'Neha', 'Rohit']],
    3 => ['isset_null' => false, 'key_exists_null' => true, 'empty_zero' => true, 'isset_zero' => true, 'missing' => false, 'zero_is_blank_string' => false],
    4 => ['has_php' => true, 'first_key' => 0, 'found' => true, 'missing' => false, 'loose_id' => true, 'strict_id' => false],
    5 => ['count_after_push' => 3, 'popped' => 'Rohit', 'shifted' => 'Neha', 'queue' => ['Aman', 'Priya'], 'empty_pop' => null],
    6 => ['merge' => ['city' => 'Pune', 'PHP', 'MySQL', 'React'], 'union' => ['city' => 'Delhi', 0 => 'PHP', 1 => 'React']],
    7 => ['values' => [60, 75, 90], 'by_score' => ['Priya' => 60, 'Rohit' => 75, 'Aman' => 90],
        'by_name' => ['Aman' => 90, 'Priya' => 60, 'Rohit' => 75], 'leaderboard' => ['Aman' => 90, 'Rohit' => 75, 'Priya' => 60],
        'original' => ['Rohit' => 75, 'Aman' => 90, 'Priya' => 60]],
    8 => ['slice' => ['Mumbai'], 'before_splice' => ['Delhi', 'Mumbai', 'Pune'], 'removed' => ['Mumbai'],
        'after_splice' => ['Delhi', 'Jaipur', 'Pune'], 'preserved_slice' => [9 => 'B']],
    9 => ['unique_keys' => [0, 1, 3], 'unique_list' => ['Delhi', 'Pune', 'Mumbai'], 'keys' => ['name', 'course'],
        'values' => ['Priya', 'BCA'], 'names' => ['Aman', 'Neha'], 'names_by_id' => [101 => 'Aman', 102 => 'Neha']],
    10 => ['discounted' => [400, 900, 1400], 'selected_keys' => [1, 2], 'selected' => [1000, 1500], 'total' => 3000,
        'keep_zero' => [0, 5], 'empty_total' => 0],
    11 => ['name' => 'Monu Giri', 'message' => 'Namaste Monu Giri, welcome!', 'total' => 'Total: 500'],
    12 => ['text' => '₹100', 'bytes' => 6, 'code_points' => function_exists('mb_strlen') ? 4 : null,
        'graphemes' => function_exists('grapheme_strlen') ? 4 : null,
        'extension_note' => 'null means the optional mbstring/intl extension is unavailable'],
    13 => ['trimmed' => 'aman sharma', 'upper' => 'AMAN SHARMA', 'words' => 'Aman Sharma', 'lower' => 'php developer',
        'inner_spaces' => 'Aman   Sharma', 'original_unchanged' => '   aman sharma   '],
    14 => ['skills' => ['PHP', 'MySQL', 'JavaScript'], 'joined' => 'PHP | MySQL | JavaScript', 'empty_part' => ['a', '', 'b']],
    15 => ['position' => 0, 'found' => true, 'case_sensitive_miss' => false, 'contains' => true, 'case_insensitive' => 0, 'empty_needle' => true],
    16 => ['prefix' => 'ORD', 'suffix' => '1045', 'updated' => 'PHP classes in Pune; workshops in Pune', 'replacements' => 2,
        'original' => 'PHP classes in Delhi; workshops in Delhi'],
    17 => ['same' => true, 'different_case' => false, 'ignore_case' => true, 'before' => true, 'after' => true],
    18 => ['escaped' => '&lt;b title=&quot;hello&quot;&gt;Namaste &amp; Aman&lt;/b&gt;', 'stripped' => 'Namaste & Aman',
        'attribute_quotes' => '&quot; onfocus=&quot;alert(1)'],
    22 => ['normalized' => 'Priya <script>alert(1)</script>', 'valid_by_demo_name_rules' => true,
        'html_text' => 'Priya &lt;script&gt;alert(1)&lt;/script&gt;'],
    23 => ['valid' => ['email' => 'priya@example.com', 'experience' => 0, 'mobile' => '0123456789', 'errors' => []],
        'invalid_errors' => ['email' => 'Enter a valid email address.', 'experience' => 'Experience must be an integer from 0 to 50.',
            'mobile' => 'Use exactly 10 ASCII digits without a country code.']],
];
foreach ($expectations as $number => $expected) {
    same($expected, runLesson($number), 'Q' . $number . ' complete result');
}

same(null, textField([], 'name'), 'missing text');
same(null, textField(['name' => ['nested']], 'name'), 'array text');
same('Aman', textField(['name' => ' Aman '], 'name'), 'normalize text');
same(null, validateName('0'), 'zero-string is a nonempty name');
same(null, validateName(str_repeat('a', 200)), 'name exact byte limit');
same(true, validateName(str_repeat('a', 201)) !== null, 'name above byte limit');
same(true, validateName(['Aman']) !== null, 'array name');
same(true, validateName('   ') !== null, 'blank name');
foreach (['', '1.5', '-1', '121', 'abc', [], null, 21] as $input) {
    same(false, integerInRange($input, 0, 120), 'invalid age ' . json_encode($input));
}
same(0, integerInRange('0', 0, 120), 'zero age');
same(120, integerInRange('120', 0, 120), 'upper age boundary');
same(21, integerInRange(' 21 ', 0, 120), 'normalized integer');
same(['values' => [], 'error' => null], validateSkills([]), 'unchecked skills');
same(['values' => ['PHP', 'MySQL'], 'error' => null], validateSkills(['PHP', 'PHP', 'MySQL']), 'skill deduplication');
foreach (['PHP', [['PHP']], ['Rust'], ['php'], [1 => 'PHP'], array_fill(0, 21, 'PHP'), null] as $input) {
    same(true, validateSkills($input)['error'] !== null, 'invalid skills ' . json_encode($input));
}
$validEnquiry = ['name' => ' Priya ', 'email' => 'priya@example.com', 'course' => 'php'];
same([], validateEnquiry($validEnquiry)['errors'], 'valid enquiry');
same('Priya', validateEnquiry($validEnquiry)['values']['name'], 'sticky normalized name');
same(['name', 'email', 'course'], array_keys(validateEnquiry(['name' => [], 'email' => [], 'course' => []])['errors']), 'array injection errors');
same(['email', 'course'], array_keys(validateEnquiry(['name' => 'A', 'email' => 'bad', 'course' => 'unknown'])['errors']), 'enquiry allowlist');
same(2500, courseFee('php'), 'server fee');
same(null, courseFee('unknown'), 'unknown course');
same(null, courseFee(['php']), 'array course');
same([], validateApplicant(['email' => 'p@example.com', 'experience' => '50', 'mobile' => '0123456789'])['errors'], 'applicant upper boundary');
same(3, count(validateApplicant(['email' => [], 'experience' => [], 'mobile' => []])['errors']), 'applicant array injection');
same(false, isset(validateApplicant(['email' => 'p@example.com', 'experience' => '0', 'mobile' => "0123456789\n"])['errors']['mobile']), 'phone trimmed before validation');
same(true, isset(validateApplicant(['email' => 'p@example.com', 'experience' => '0', 'mobile' => '１２３４５６７８９０'])['errors']['mobile']), 'phone ASCII requirement');
same('&lt;&amp;&quot;&#039;&gt;', escapeHtml('<&"\'>'), 'escape HTML and both quotes');
same("\u{FFFD}", escapeHtml("\xFF"), 'substitute malformed UTF-8');
$token = str_repeat('a', 64);
same(true, validCsrf($token, $token), 'matching CSRF');
foreach ([null, [], '', str_repeat('b', 64), 'a'] as $bad) {
    same(false, validCsrf($bad, $token), 'invalid CSRF');
}
same(false, validCsrf('', ''), 'missing session CSRF');
same(null, uploadPolicy(UPLOAD_ERR_OK, 1, 'application/pdf'), 'upload lower boundary');
same(null, uploadPolicy(UPLOAD_ERR_OK, MAX_UPLOAD_BYTES, 'application/pdf'), 'upload upper boundary');
foreach ([[UPLOAD_ERR_NO_FILE, false, false], [UPLOAD_ERR_INI_SIZE, 1, 'application/pdf'],
    [UPLOAD_ERR_OK, 0, 'application/pdf'], [UPLOAD_ERR_OK, MAX_UPLOAD_BYTES + 1, 'application/pdf'],
    [UPLOAD_ERR_OK, false, 'application/pdf'], [UPLOAD_ERR_OK, 100, 'text/plain']] as $args) {
    same(true, uploadPolicy(...$args) !== null, 'invalid upload policy');
}
$topics = json_decode(file_get_contents(dirname(__DIR__) . '/lib/topics.json'), true, 512, JSON_THROW_ON_ERROR);
same(28, count($topics), 'coverage: 28 original topics');
for ($i = 1; $i <= 28; ++$i) {
    same(true, is_file(dirname(__DIR__) . '/Question_' . $i . '.php'), 'coverage file ' . $i);
}
echo "$passed passed, $failed failed\n";
if (!function_exists('mb_strlen')) { echo "SKIP: mbstring code-point branch is unavailable.\n"; }
if (!function_exists('grapheme_strlen')) { echo "SKIP: intl grapheme branch is unavailable.\n"; }
exit($failed === 0 ? 0 : 1);
