document.addEventListener("DOMContentLoaded", function () {
    var table = document.querySelector("#kt_table_users");

    if (!table) {
        console.error("❌ Error: Table #kt_table_users not found!");
        return; // Stop script execution if table doesn't exist
    }

    console.log("✅ Table found. Initializing export...");

    if (!$.fn.DataTable) {
        console.error("❌ Error: DataTables plugin not loaded!");
        return;
    }

    console.log("✅ Initializing DataTable...");

    try {
        datatable = $(table).DataTable({
            "info": false,
            "order": [],
            "pageLength": 10,
            "lengthChange": false,
            'columnDefs': [
                { orderable: false, targets: 0 },
                { orderable: false, targets: 5 }
            ]
        });

        datatable.on('draw', function () {
            console.log("🔄 Table redrawn...");
        });

    } catch (error) {
        console.error("❌ DataTables error:", error);
    }

    console.log("✅ Table initialized successfully.");
});
