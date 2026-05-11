<?php

namespace App\Services\SatuSehat;

use App\Services\SatuSehat\Bridge\BridgeBase;
use App\Services\SatuSehat\Bridge\BridgeKfa;
use App\Services\SatuSehat\Bridge\BridgeKfaV2;
use App\Services\SatuSehat\Bridge\BridgeConsent;

class ReferensiController
{
    protected BridgeBase $bridging;

    public function __construct()
    {
        $this->bridging = new BridgeBase();
    }

    // ══════════════════════════════════════════════════════════════════════
    // PATIENT
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Cari data pasien berdasarkan NIK.
     */
    public function patient(string $nik): array
    {
        return $this->bridging->getJson(
            'Patient?identifier=https://fhir.kemkes.go.id/id/nik|' . $nik
        );
    }

    /**
     * Ambil data pasien berdasarkan ID SatuSehat (Patient IHS Number).
     */
    public function patientById(string $id): array
    {
        return $this->bridging->getJson('Patient/' . $id);
    }

    // ══════════════════════════════════════════════════════════════════════
    // PRACTITIONER (Dokter)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Cari data practitioner (dokter/tenaga medis) berdasarkan NIK.
     */
    public function practitioner(string $nik): array
    {
        return $this->bridging->getJson(
            'Practitioner?identifier=https://fhir.kemkes.go.id/id/nik|' . $nik
        );
    }

    /**
     * Ambil data practitioner berdasarkan ID SatuSehat.
     */
    public function practitionerById(string $id): array
    {
        return $this->bridging->getJson('Practitioner/' . $id);
    }

    // ══════════════════════════════════════════════════════════════════════
    // ORGANIZATION (Fasilitas Kesehatan)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Ambil data organisasi (faskes) berdasarkan Organization ID SatuSehat.
     */
    public function organization(string $orgId): array
    {
        return $this->bridging->getJson('Organization/' . $orgId);
    }

    // ══════════════════════════════════════════════════════════════════════
    // LOCATION (Ruangan / Poli)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Ambil daftar lokasi (ruangan/poli) milik organisasi faskes.
     */
    public function locationByOrganization(string $orgId): array
    {
        return $this->bridging->getJson('Location?organization=' . $orgId);
    }

    /**
     * Ambil data lokasi berdasarkan Location ID SatuSehat.
     */
    public function locationById(string $locationId): array
    {
        return $this->bridging->getJson('Location/' . $locationId);
    }

    // ══════════════════════════════════════════════════════════════════════
    // ENCOUNTER (Kunjungan)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Kirim data kunjungan (Encounter) baru ke SatuSehat.
     */
    public function createEncounter(array $payload): array
    {
        return $this->bridging->postJson('Encounter', $payload);
    }

    /**
     * Update data kunjungan.
     */
    public function updateEncounter(string $encounterId, array $payload): array
    {
        return $this->bridging->putJson('Encounter/' . $encounterId, $payload);
    }

    /**
     * Ambil data kunjungan berdasarkan ID.
     */
    public function encounterById(string $encounterId): array
    {
        return $this->bridging->getJson('Encounter/' . $encounterId);
    }

    // ══════════════════════════════════════════════════════════════════════
    // CONDITION (Diagnosa / ICD-10)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Kirim data kondisi/diagnosa pasien.
     */
    public function createCondition(array $payload): array
    {
        return $this->bridging->postJson('Condition', $payload);
    }

    /**
     * Update data kondisi pasien.
     */
    public function updateCondition(string $conditionId, array $payload): array
    {
        return $this->bridging->putJson('Condition/' . $conditionId, $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // OBSERVATION (Tanda Vital / Hasil Pemeriksaan)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Kirim data observasi (tanda vital, hasil lab, dll).
     */
    public function createObservation(array $payload): array
    {
        return $this->bridging->postJson('Observation', $payload);
    }

    /**
     * Update data observasi.
     */
    public function updateObservation(string $observationId, array $payload): array
    {
        return $this->bridging->putJson('Observation/' . $observationId, $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // MEDICATION REQUEST (Resep)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Kirim data resep obat pasien.
     */
    public function createMedicationRequest(array $payload): array
    {
        return $this->bridging->postJson('MedicationRequest', $payload);
    }

    /**
     * Update data resep obat.
     */
    public function updateMedicationRequest(string $id, array $payload): array
    {
        return $this->bridging->putJson('MedicationRequest/' . $id, $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // PROCEDURE (Tindakan)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Kirim data tindakan medis.
     */
    public function createProcedure(array $payload): array
    {
        return $this->bridging->postJson('Procedure', $payload);
    }

    /**
     * Update data tindakan medis.
     */
    public function updateProcedure(string $procedureId, array $payload): array
    {
        return $this->bridging->putJson('Procedure/' . $procedureId, $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // ORGANIZATION (Create)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data organisasi (fasilitas kesehatan).
     */
    public function createOrganization(array $payload): array
    {
        return $this->bridging->postJson('Organization', $payload);
    }

    /**
     * Update (PUT) data organisasi berdasarkan ID SatuSehat.
     */
    public function updateOrganization(string $id, array $payload): array
    {
        return $this->bridging->putJson('Organization/' . $id, $payload);
    }

    /**
     * Patch data organisasi berdasarkan ID SatuSehat.
     */
    public function patchOrganization(string $id, array $payload): array
    {
        return $this->bridging->patchJson('Organization/' . $id, $payload);
    }

    /**
     * Cari organisasi berdasarkan nama.
     */
    public function searchOrganizationByName(string $name): array
    {
        return $this->bridging->getJson('Organization?name=' . urlencode($name));
    }

    /**
     * Cari organisasi berdasarkan partOf (ID organisasi induk).
     */
    public function searchOrganizationByPartOf(string $orgId): array
    {
        return $this->bridging->getJson('Organization?partof=' . $orgId);
    }

    // ══════════════════════════════════════════════════════════════════════
    // LOCATION (Create / Update / Patch / Search)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data lokasi (ruangan/poli).
     */
    public function createLocation(array $payload): array
    {
        return $this->bridging->postJson('Location', $payload);
    }

    /**
     * Update (PUT) data lokasi berdasarkan ID SatuSehat.
     */
    public function updateLocation(string $id, array $payload): array
    {
        return $this->bridging->putJson('Location/' . $id, $payload);
    }

    /**
     * Patch data lokasi berdasarkan ID SatuSehat.
     */
    public function patchLocation(string $id, array $payload): array
    {
        return $this->bridging->patchJson('Location/' . $id, $payload);
    }

    /**
     * Cari lokasi berdasarkan nama.
     */
    public function searchLocationByName(string $name): array
    {
        return $this->bridging->getJson('Location?name=' . urlencode($name));
    }

    // ══════════════════════════════════════════════════════════════════════
    // PATIENT (Search by name)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Cari pasien berdasarkan nama, tanggal lahir, dan/atau gender.
     */
    public function patientByName(string $name, string $birthdate = '', string $gender = ''): array
    {
        $params = [];
        if (!empty($name))      $params[] = 'name='      . urlencode($name);
        if (!empty($birthdate)) $params[] = 'birthdate=' . urlencode($birthdate);
        if (!empty($gender))    $params[] = 'gender='    . urlencode($gender);
        $query = implode('&', $params);
        return $this->bridging->getJson('Patient?' . $query);
    }

    // ══════════════════════════════════════════════════════════════════════
    // PRACTITIONER (Search by name)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Cari practitioner berdasarkan nama, tanggal lahir, dan/atau gender.
     */
    public function practitionerByName(string $name, string $birthdate = '', string $gender = ''): array
    {
        $params = [];
        if (!empty($name))      $params[] = 'name='      . urlencode($name);
        if (!empty($birthdate)) $params[] = 'birthdate=' . urlencode($birthdate);
        if (!empty($gender))    $params[] = 'gender='    . urlencode($gender);
        $query = implode('&', $params);
        return $this->bridging->getJson('Practitioner?' . $query);
    }

    // ══════════════════════════════════════════════════════════════════════
    // FAMILY MEMBER HISTORY
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data riwayat penyakit keluarga.
     */
    public function createFamilyMemberHistory(array $payload): array
    {
        return $this->bridging->postJson('FamilyMemberHistory', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // ALLERGY INTOLERANCE
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data alergi/intoleransi.
     */
    public function createAllergyIntolerance(array $payload): array
    {
        return $this->bridging->postJson('AllergyIntolerance', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // MEDICATION STATEMENT
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data riwayat pengobatan.
     */
    public function createMedicationStatement(array $payload): array
    {
        return $this->bridging->postJson('MedicationStatement', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // MEDICATION DISPENSE
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Ambil data pengeluaran obat berdasarkan patient ID.
     */
    public function getMedicationDispense(string $patientId): array
    {
        return $this->bridging->getJson('MedicationDispense?subject=' . $patientId);
    }

    /**
     * Buat data pengeluaran obat.
     */
    public function createMedicationDispense(array $payload): array
    {
        return $this->bridging->postJson('MedicationDispense', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // MEDICATION ADMINISTRATION
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data pemberian obat.
     */
    public function createMedicationAdministration(array $payload): array
    {
        return $this->bridging->postJson('MedicationAdministration', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // CLINICAL IMPRESSION
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data clinical impression (riwayat/rasional klinis).
     */
    public function createClinicalImpression(array $payload): array
    {
        return $this->bridging->postJson('ClinicalImpression', $payload);
    }

    /**
     * Update clinical impression dengan PATCH method.
     */
    public function patchClinicalImpression(string $id, array $payload): array
    {
        return $this->bridging->patchJson('ClinicalImpression/' . $id, $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // GOAL
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data tujuan perawatan.
     */
    public function createGoal(array $payload): array
    {
        return $this->bridging->postJson('Goal', $payload);
    }

    /**
     * Update data tujuan perawatan.
     */
    public function updateGoal(string $id, array $payload): array
    {
        return $this->bridging->putJson('Goal/' . $id, $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // CARE PLAN
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data rencana rawat/perawatan pasien.
     */
    public function createCarePlan(array $payload): array
    {
        return $this->bridging->postJson('CarePlan', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // SERVICE REQUEST
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data permintaan layanan (lab, radiologi, dll).
     */
    public function createServiceRequest(array $payload): array
    {
        return $this->bridging->postJson('ServiceRequest', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // SPECIMEN
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data spesimen (sampel).
     */
    public function createSpecimen(array $payload): array
    {
        return $this->bridging->postJson('Specimen', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // DIAGNOSTIC REPORT
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data laporan diagnostik.
     */
    public function createDiagnosticReport(array $payload): array
    {
        return $this->bridging->postJson('DiagnosticReport', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // IMAGING STUDY
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Ambil data imaging study berdasarkan nomor akses (ACSN).
     */
    public function getImagingStudy(string $orgId, string $acsn): array
    {
        return $this->bridging->getJson(
            'ImagingStudy?identifier=http://sys-ids.kemkes.go.id/acsn/' . $orgId . '|' . $acsn
        );
    }

    // ══════════════════════════════════════════════════════════════════════
    // RISK ASSESSMENT
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data penilaian risiko.
     */
    public function createRiskAssessment(array $payload): array
    {
        return $this->bridging->postJson('RiskAssessment', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // QUESTIONNAIRE RESPONSE
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data jawaban questionnaire (pengkajian resep, dll).
     */
    public function createQuestionnaireResponse(array $payload): array
    {
        return $this->bridging->postJson('QuestionnaireResponse', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // MEDICATION
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data obat/medication.
     */
    public function createMedication(array $payload): array
    {
        return $this->bridging->postJson('Medication', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // NUTRITION ORDER
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data order nutrisi.
     */
    public function createNutritionOrder(array $payload): array
    {
        return $this->bridging->postJson('NutritionOrder', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // COMPOSITION
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat data composition (dokumen klinis).
     */
    public function createComposition(array $payload): array
    {
        return $this->bridging->postJson('Composition', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // BUNDLE
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Kirim bundle (kumpulan resource) ke base URL.
     */
    public function postBundle(array $payload): array
    {
        return $this->bridging->postJson('/', $payload);
    }

    // ══════════════════════════════════════════════════════════════════════
    // KFA (Katalog Farmasi)
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Cari produk di Katalog Farmasi (KFA) berdasarkan keyword.
     */
    public function kfaSearch(string $keyword): array
    {
        $kfa = new BridgeKfa();
        return $kfa->getJson('products?keyword=' . urlencode($keyword) . '&page=1&pageSize=10');
    }

    /**
     * Ambil detail produk KFA berdasarkan kode.
     */
    public function kfaDetail(string $productCode): array
    {
        $kfa = new BridgeKfa();
        return $kfa->getJson('products/' . $productCode);
    }

    /**
     * Cari produk di KFA v2 berdasarkan keyword.
     */
    public function kfaV2Search(string $keyword): array
    {
        $kfa = new BridgeKfaV2();
        return $kfa->getJson('products?keyword=' . urlencode($keyword));
    }

    // ══════════════════════════════════════════════════════════════════════
    // CONSENT
    // ══════════════════════════════════════════════════════════════════════

    /**
     * Buat consent pasien.
     */
    public function createConsent(array $payload): array
    {
        $consent = new BridgeConsent();
        return $consent->postJson('Consent', $payload);
    }

    /**
     * Cek status consent pasien berdasarkan patient ID.
     */
    public function getConsent(string $patientId): array
    {
        $consent = new BridgeConsent();
        return $consent->getJson('Consent?patient=' . $patientId);
    }
}
