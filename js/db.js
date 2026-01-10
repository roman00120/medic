/**
 * ABCD Médica DB Service (SQL Version)
 * Se conecta a los scripts PHP para guardar datos en una base de datos MySQL.
 */

const PHP_API = 'php/api.php';

const DB = {
    // --- USUARIOS ---
    findUser: async (email) => {
        // En esta versión, la validación se hace directamente en el login/registro de la API
        return null;
    },

    saveUser: async (userData) => {
        const response = await fetch(`${PHP_API}?action=register`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(userData)
        });
        return await response.json();
    },

    login: async (email, password) => {
        const response = await fetch(`${PHP_API}?action=login`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });
        return await response.json();
    },

    // --- EXPEDIENTES ---
    getRecords: async (userId) => {
        const response = await fetch(`${PHP_API}?action=get_records&userId=${userId}`);
        return await response.json();
    },

    saveRecord: async (recordData) => {
        const response = await fetch(`${PHP_API}?action=save_record`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(recordData)
        });
        return await response.json();
    },

    updatePaymentStatus: async (recordId) => {
        const response = await fetch(`${PHP_API}?action=update_payment_status`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ recordId })
        });
        return await response.json();
    },

    getPaidConsultations: async () => {
        const response = await fetch(`${PHP_API}?action=get_paid_consultations`);
        return await response.json();
    }
};

window.ABCD_DB = DB;
