<?php
declare(strict_types=1);

const COURSES = ['php' => 'PHP Development', 'web' => 'Web Development', 'bca' => 'BCA Coaching'];
const COURSE_FEES = ['php' => 2500, 'web' => 4000];
const ALLOWED_SKILLS = ['PHP', 'MySQL', 'JavaScript'];
const MAX_UPLOAD_BYTES = 2 * 1024 * 1024;

function escapeHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Array/null/missing values are not silently converted into strings. */
function textField(array $input, string $key): ?string
{
    $value = $input[$key] ?? null;
    return is_string($value) ? trim($value) : null;
}

function validateName(mixed $value): ?string
{
    if (!is_string($value) || trim($value) === '') {
        return 'A non-empty name is required.';
    }
    return strlen(trim($value)) <= 200 ? null : 'Name must be at most 200 bytes.';
}

function integerInRange(mixed $value, int $min, int $max): int|false
{
    if (!is_string($value)) {
        return false;
    }
    return filter_var(trim($value), FILTER_VALIDATE_INT, ['options' => ['min_range' => $min, 'max_range' => $max]]);
}

/** Format checks only; this does not prove ownership of the contact details. */
function validateApplicant(array $input): array
{
    $email = textField($input, 'email');
    $mobile = textField($input, 'mobile');
    $experience = integerInRange($input['experience'] ?? null, 0, 50);
    $errors = [];
    if ($email === null || strlen($email) > 254 || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Enter a valid email address.';
    }
    if ($experience === false) {
        $errors['experience'] = 'Experience must be an integer from 0 to 50.';
    }
    if ($mobile === null || preg_match('/\A[0-9]{10}\z/', $mobile) !== 1) {
        $errors['mobile'] = 'Use exactly 10 ASCII digits without a country code.';
    }
    return ['email' => $email, 'experience' => $experience, 'mobile' => $mobile, 'errors' => $errors];
}

/** Only a flat list is accepted. Missing checkboxes are represented as []. */
function validateSkills(mixed $skills): array
{
    if (!is_array($skills) || !array_is_list($skills) || count($skills) > 20) {
        return ['values' => [], 'error' => 'Skills must be a list with at most 20 entries.'];
    }
    foreach ($skills as $skill) {
        if (!is_string($skill) || !in_array($skill, ALLOWED_SKILLS, true)) {
            return ['values' => [], 'error' => 'An unknown or malformed skill was submitted.'];
        }
    }
    return ['values' => array_values(array_unique($skills)), 'error' => null];
}

function validateEnquiry(array $input): array
{
    $values = ['name' => textField($input, 'name') ?? '',
        'email' => textField($input, 'email') ?? '', 'course' => textField($input, 'course') ?? ''];
    $errors = [];
    if (($error = validateName($values['name'])) !== null) {
        $errors['name'] = $error;
    }
    if (strlen($values['email']) > 254 || filter_var($values['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Enter a valid email address.';
    }
    if (!array_key_exists($values['course'], COURSES)) {
        $errors['course'] = 'Select an allowed course.';
    }
    return ['values' => $values, 'errors' => $errors];
}

function courseFee(mixed $course): ?int
{
    return is_string($course) && array_key_exists($course, COURSE_FEES) ? COURSE_FEES[$course] : null;
}

function validCsrf(mixed $submitted, mixed $stored): bool
{
    return is_string($submitted) && is_string($stored) && strlen($stored) === 64
        && hash_equals($stored, $submitted);
}

/** Tests can exercise policy without fabricating a genuine HTTP upload. */
function uploadPolicy(int $error, int|false $actualSize, string|false $detectedMime): ?string
{
    if ($error !== UPLOAD_ERR_OK) {
        return 'Upload failed; choose a file within the configured server limits.';
    }
    if ($actualSize === false || $actualSize < 1 || $actualSize > MAX_UPLOAD_BYTES) {
        return 'The file must contain 1 byte to 2 MiB.';
    }
    return $detectedMime === 'application/pdf' ? null : 'Only a server-detected PDF is allowed.';
}
