<?php

use App\Services\SatuSehat\ReferensiController;
use App\Services\SatuSehat\Foundation\Http\Authentication;
use App\Services\SatuSehat\Config\ConfigSatusehat;
use App\Services\SatuSehat\Bridge\BridgeBase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| SatuSehat Development / Debug Routes
| Gunakan hanya untuk testing — jangan expose ke production tanpa proteksi
|--------------------------------------------------------------------------
*/

Route::prefix('satusehat')->middleware(['web'])->group(function () {

    // ── Dashboard (Swagger-style UI) ──────────────────────────────
    Route::get('/', function () {
        $config = new ConfigSatusehat();
        return view('satusehat.dashboard', [
            'orgId'  => $config->getOrganizationId(),
        ]);
    });

    // ── Token ─────────────────────────────────────────────────────
    Route::get('/token', function () {
        $config    = new ConfigSatusehat();
        $fromCache = Cache::has('satusehat_access_token');
        try {
            $auth   = new Authentication($config->getUrlAuth() . 'accesstoken?grant_type=client_credentials', $config->getCredentials());
            $token  = $auth->getToken();
            $masked = substr($token, 0, 12) . str_repeat('*', max(0, strlen($token) - 24)) . substr($token, -12);
            return response()->json([
                'status'        => 'ok',
                'from_cache'    => $fromCache,
                'token_preview' => $masked,
                'token_length'  => strlen($token),
                'cache_key'     => 'satusehat_access_token',
                'message'       => $fromCache ? 'Token diambil dari cache' : 'Token baru diminta dari SatuSehat',
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    });

    Route::get('/token/refresh', function () {
        Authentication::forgetToken();
        $config = new ConfigSatusehat();
        try {
            $auth   = new Authentication($config->getUrlAuth() . 'accesstoken?grant_type=client_credentials', $config->getCredentials());
            $token  = $auth->getToken();
            $masked = substr($token, 0, 12) . str_repeat('*', max(0, strlen($token) - 24)) . substr($token, -12);
            return response()->json([
                'status'        => 'ok',
                'from_cache'    => false,
                'token_preview' => $masked,
                'token_length'  => strlen($token),
                'message'       => 'Token berhasil di-refresh dari SatuSehat API',
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    });

    // ── Organization ──────────────────────────────────────────────
    Route::get('/organization', function () {
        $orgId = (new ConfigSatusehat())->getOrganizationId();
        if (!$orgId) return response()->json(['error' => 'SATUSEHAT_ORGANIZATION_ID belum diset di .env'], 422);
        return response()->json((new ReferensiController())->organization($orgId));
    });

    Route::get('/organization/{orgId}', function (string $orgId) {
        return response()->json((new ReferensiController())->organization($orgId));
    });

    Route::post('/organization', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createOrganization($payload));
    });

    // ── Location ──────────────────────────────────────────────────
    Route::get('/location', function () {
        $orgId = (new ConfigSatusehat())->getOrganizationId();
        if (!$orgId) return response()->json(['error' => 'SATUSEHAT_ORGANIZATION_ID belum diset di .env'], 422);
        return response()->json((new ReferensiController())->locationByOrganization($orgId));
    });

    Route::get('/location/{orgId}', function (string $orgId) {
        return response()->json((new ReferensiController())->locationByOrganization($orgId));
    });

    Route::post('/location', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createLocation($payload));
    });

    // ── Patient ───────────────────────────────────────────────────
    Route::get('/patient/{nik}', function (string $nik) {
        return response()->json((new ReferensiController())->patient($nik));
    });

    Route::get('/patient-by-id/{id}', function (string $id) {
        return response()->json((new ReferensiController())->patientById($id));
    });

    Route::get('/patient-by-name', function (Request $request) {
        $params = [];
        if ($request->query('name'))      $params[] = 'name='      . urlencode($request->query('name'));
        if ($request->query('birthdate')) $params[] = 'birthdate=' . urlencode($request->query('birthdate'));
        if ($request->query('gender'))    $params[] = 'gender='    . urlencode($request->query('gender'));
        if (empty($params)) {
            return response()->json(['error' => 'Minimal satu parameter diperlukan: name, birthdate, atau gender'], 422);
        }
        $bridge = new BridgeBase();
        return response()->json($bridge->getJson('Patient?' . implode('&', $params)));
    });

    // ── Practitioner ──────────────────────────────────────────────
    Route::get('/practitioner/{nik}', function (string $nik) {
        return response()->json((new ReferensiController())->practitioner($nik));
    });

    Route::get('/practitioner-by-id/{id}', function (string $id) {
        return response()->json((new ReferensiController())->practitionerById($id));
    });

    Route::get('/practitioner-by-name', function (Request $request) {
        $params = [];
        if ($request->query('name'))      $params[] = 'name='      . urlencode($request->query('name'));
        if ($request->query('birthdate')) $params[] = 'birthdate=' . urlencode($request->query('birthdate'));
        if ($request->query('gender'))    $params[] = 'gender='    . urlencode($request->query('gender'));
        if (empty($params)) {
            return response()->json(['error' => 'Minimal satu parameter diperlukan: name, birthdate, atau gender'], 422);
        }
        $bridge = new BridgeBase();
        return response()->json($bridge->getJson('Practitioner?' . implode('&', $params)));
    });

    // ── Encounter ─────────────────────────────────────────────────
    Route::get('/encounter/{id}', function (string $id) {
        return response()->json((new ReferensiController())->encounterById($id));
    });

    Route::post('/encounter', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createEncounter($payload));
    });

    Route::put('/encounter/{id}', function (Request $request, string $id) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->updateEncounter($id, $payload));
    });

    // ── Condition ─────────────────────────────────────────────────
    Route::post('/condition', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createCondition($payload));
    });

    Route::put('/condition/{id}', function (Request $request, string $id) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->updateCondition($id, $payload));
    });

    // ── Observation ───────────────────────────────────────────────
    Route::post('/observation', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createObservation($payload));
    });

    Route::put('/observation/{id}', function (Request $request, string $id) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->updateObservation($id, $payload));
    });

    // ── Procedure ─────────────────────────────────────────────────
    Route::post('/procedure', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createProcedure($payload));
    });

    Route::put('/procedure/{id}', function (Request $request, string $id) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->updateProcedure($id, $payload));
    });

    // ── MedicationRequest ─────────────────────────────────────────
    Route::post('/medication-request', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createMedicationRequest($payload));
    });

    Route::put('/medication-request/{id}', function (Request $request, string $id) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->updateMedicationRequest($id, $payload));
    });

    // ── KFA ───────────────────────────────────────────────────────
    Route::get('/kfa/search/{keyword}', function (string $keyword) {
        return response()->json((new ReferensiController())->kfaSearch($keyword));
    });

    Route::get('/kfa/detail/{code}', function (string $code) {
        return response()->json((new ReferensiController())->kfaDetail($code));
    });

    Route::get('/kfa-v2/search/{keyword}', function (string $keyword) {
        return response()->json((new ReferensiController())->kfaV2Search($keyword));
    });

    // ── Consent ───────────────────────────────────────────────────
    Route::get('/consent/{patientId}', function (string $patientId) {
        return response()->json((new ReferensiController())->getConsent($patientId));
    });

    // ── Family Member History ─────────────────────────────────────
    Route::post('/family-member-history', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createFamilyMemberHistory($payload));
    });

    // ── Allergy Intolerance ───────────────────────────────────────
    Route::post('/allergy-intolerance', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createAllergyIntolerance($payload));
    });

    // ── Medication Statement ──────────────────────────────────────
    Route::post('/medication-statement', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createMedicationStatement($payload));
    });

    // ── Medication Dispense ───────────────────────────────────────
    Route::get('/medication-dispense', function (Request $request) {
        $patientId = $request->query('patient_id');
        if (!$patientId) return response()->json(['error' => 'parameter patient_id diperlukan'], 422);
        return response()->json((new ReferensiController())->getMedicationDispense($patientId));
    });

    Route::post('/medication-dispense', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createMedicationDispense($payload));
    });

    // ── Medication Administration ─────────────────────────────────
    Route::post('/medication-administration', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createMedicationAdministration($payload));
    });

    // ── Clinical Impression ───────────────────────────────────────
    Route::post('/clinical-impression', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createClinicalImpression($payload));
    });

    Route::patch('/clinical-impression/{id}', function (Request $request, string $id) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->patchClinicalImpression($id, $payload));
    });

    // ── Goal ──────────────────────────────────────────────────────
    Route::post('/goal', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createGoal($payload));
    });

    Route::put('/goal/{id}', function (Request $request, string $id) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->updateGoal($id, $payload));
    });

    // ── Care Plan ─────────────────────────────────────────────────
    Route::post('/care-plan', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createCarePlan($payload));
    });

    // ── Service Request ───────────────────────────────────────────
    Route::post('/service-request', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createServiceRequest($payload));
    });

    // ── Specimen ──────────────────────────────────────────────────
    Route::post('/specimen', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createSpecimen($payload));
    });

    // ── Diagnostic Report ─────────────────────────────────────────
    Route::post('/diagnostic-report', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createDiagnosticReport($payload));
    });

    // ── Imaging Study ─────────────────────────────────────────────
    Route::get('/imaging-study', function (Request $request) {
        $orgId = $request->query('org_id');
        $acsn = $request->query('acsn');
        if (!$orgId || !$acsn) {
            return response()->json(['error' => 'parameter org_id dan acsn diperlukan'], 422);
        }
        return response()->json((new ReferensiController())->getImagingStudy($orgId, $acsn));
    });

    // ── Risk Assessment ───────────────────────────────────────────
    Route::post('/risk-assessment', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createRiskAssessment($payload));
    });

    // ── Questionnaire Response ────────────────────────────────────
    Route::post('/questionnaire-response', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createQuestionnaireResponse($payload));
    });

    // ── Medication ────────────────────────────────────────────────
    Route::post('/medication', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createMedication($payload));
    });

    // ── Nutrition Order ───────────────────────────────────────────
    Route::post('/nutrition-order', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createNutritionOrder($payload));
    });

    // ── Composition ───────────────────────────────────────────────
    Route::post('/composition', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->createComposition($payload));
    });

    // ── Bundle ────────────────────────────────────────────────────
    Route::post('/bundle', function (Request $request) {
        $payload = $request->json()->all();
        return response()->json((new ReferensiController())->postBundle($payload));
    });

});
