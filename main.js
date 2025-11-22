$(document).ready(function () {

    // ===================== FORM VALIDATION + ADD STUDENT =====================
    $("#studentForm").submit(function (e) {
        e.preventDefault();
        let valid = true;
        $(".error").text("");

        const id = $("#studentID").val().trim();
        const last = $("#lastName").val().trim();
        const first = $("#firstName").val().trim();
        const email = $("#email").val().trim();

        if (!/^[0-9]+$/.test(id)) { $("#idError").text("ID must be numeric."); valid = false; }
        if (!/^[A-Za-z]+$/.test(last)) { $("#lastError").text("Only letters allowed."); valid = false; }
        if (!/^[A-Za-z]+$/.test(first)) { $("#firstError").text("Only letters allowed."); valid = false; }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { $("#emailError").text("Invalid email."); valid = false; }

        if (valid) {
           const newRow = `
<tr>
  <td>${last}</td>
  <td>${first}</td>
  <td></td><td></td><td></td><td></td><td></td><td></td> 
  <td></td><td></td><td></td><td></td><td></td><td></td> 
  <td>0</td> 
  <td>0</td> 
  <td>New student added</td>
</tr>`;


            $("#attendanceTable tbody").append(newRow);
            makeCellsClickable();
            updateAbsences();
            alert("Student added successfully!");
            this.reset();
        }
    });

    // ===================== UPDATE ABSENCES =====================
    function updateAbsences() {
        $("#attendanceTable tbody tr").each(function () {
            const cells = $(this).find("td");

            let abs = 0, part = 0;

            cells.slice(2, 8).each(function () { if ($(this).text().trim() !== "✓") abs++; });
            cells.slice(8, 14).each(function () { if ($(this).text().trim() === "✓") part++; });

            cells.eq(14).text(abs + " Abs");
            cells.eq(15).text(part + " Par");

            if (abs < 3) $(this).css("background-color", "#d4edda");
            else if (abs <= 4) $(this).css("background-color", "#fff3cd");
            else $(this).css("background-color", "#f8d7da");

            let msg =
                abs < 3 ? "Good attendance – Excellent participation" :
                    abs <= 4 ? "Warning – attendance low – Participate more" :
                        "Excluded – too many absences";

            cells.eq(16).text(msg);
        });
    }

    updateAbsences();

    // ===================== CLICKABLE CELLS =====================
    function makeCellsClickable() {
        $("#attendanceTable tbody tr").each(function () {
            $(this).find("td").slice(2, 14).off("click").on("click", function () {
                $(this).text($(this).text() === "✓" ? "" : "✓");
                updateAbsences();
            });
        });
    }

    makeCellsClickable();

    // ===================== SEARCH FILTER (Exercise 7) =====================
    $("#searchInput").on("keyup", function () {
        const filter = $(this).val().toLowerCase();

        $("#attendanceTable tbody tr").filter(function () {
            const last = $(this).find("td:eq(0)").text().toLowerCase();
            const first = $(this).find("td:eq(1)").text().toLowerCase();
            $(this).toggle(last.includes(filter) || first.includes(filter));
        });
    });

    // ===================== EXERCISE 6: HIGHLIGHT EXCELLENT STUDENTS =====================
    $("#highlightExcellent").click(function () {
        $("#attendanceTable tbody tr").each(function () {
            const abs = parseInt($(this).find("td").eq(14).text());
            if (abs < 3) {
                $(this)
                    .css("background-color", "#90EE90")
                    .fadeOut(200).fadeIn(200);
            }
        });
    });

    $("#resetColors").click(function () {
        updateAbsences();
    });

    // ===================== EXERCISE 7 SORTING =====================
    $("#sortAbs").click(function () {
        const rows = $("#attendanceTable tbody tr").get();

        rows.sort(function (a, b) {
            const absA = parseInt($(a).find("td").eq(14).text());
            const absB = parseInt($(b).find("td").eq(14).text());
            return absA - absB;
        });

        $("#attendanceTable tbody").append(rows);
        $("#sortMessage").text("Currently sorted by absences (ascending)");
    });

    $("#sortPart").click(function () {
        const rows = $("#attendanceTable tbody tr").get();

        rows.sort(function (a, b) {
            const pA = parseInt($(a).find("td").eq(15).text());
            const pB = parseInt($(b).find("td").eq(15).text());
            return pB - pA;
        });

        $("#attendanceTable tbody").append(rows);
        $("#sortMessage").text("Currently sorted by participation (descending)");
    });

    // ===================== REPORT (Exercise 4) =====================
    $("#showReport").click(function () {
        const rows = $("#attendanceTable tbody tr:visible");
        const total = rows.length;

        let present = 0, participated = 0;

        rows.each(function () {
            if ($(this).find("td").slice(2, 8).filter((i, td) => $(td).text() === "✓").length > 0)
                present++;

            if ($(this).find("td").slice(8, 14).filter((i, td) => $(td).text() === "✓").length > 0)
                participated++;
        });

        $("#totalStudents").text(`Total Students: ${total}`);
        $("#presentCount").text(`Present: ${present}`);
        $("#participatedCount").text(`Participated: ${participated}`);

        const ctx = $("#reportChart")[0].getContext("2d");

        if (window.reportChart) window.reportChart.destroy();

        window.reportChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Total", "Present", "Participated"],
                datasets: [{
                    label: "Attendance Report",
                    data: [total, present, participated],
                    backgroundColor: ["#3498db", "#2ecc71", "#f1c40f"]
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });

    // ===================== EXERCISE 5: HOVER & CLICK =====================
    // Highlight row on mouse hover
    $("#attendanceTable tbody tr").hover(
        function () { // mouse enter
            $(this).css("background-color", "#ffeaa7"); // yellow highlight
        },
        function () { // mouse leave
            updateAbsences(); // restore original colors based on absences
        }
    );

    // Show student info on row click
    $("#attendanceTable tbody tr").click(function () {
        const last = $(this).find("td").eq(0).text();
        const first = $(this).find("td").eq(1).text();
        const absences = $(this).find("td").eq(14).text(); // absences column
        alert(`Student: ${first} ${last}\nAbsences: ${absences}`);
    });

});
