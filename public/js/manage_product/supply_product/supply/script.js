$(document).ready(function () {
    $(".total-field").each(function () {
        var harga = $(this).prev().children().first().val();
        var jumlah = $(this).prev().prev().text();
        var total = parseInt(harga) * parseInt(jumlah);
        $(this).text("- Rp. " + parseInt(total).toLocaleString() + ",00");
    });

    $(document).ready(function () {
        $("input[name=search]").on("keyup", function () {
            var searchTerm = $(this).val().toLowerCase();
            $(".list-date table").each(function () {
                var hasMatch = false;

                // Iterasi setiap baris dalam tabel
                $(this)
                    .find(".supply-row")
                    .each(function () {
                        var lineStr = $(this).text().toLowerCase();
                        if (lineStr.indexOf(searchTerm) == -1) {
                            $(this).hide(); // Sembunyikan baris yang tidak cocok
                        } else {
                            $(this).show(); // Tampilkan baris yang cocok
                            hasMatch = true; // Tandai bahwa ada kecocokan
                        }
                    });

                // // Sembunyikan tabel jika tidak ada baris yang cocok
                // if (!hasMatch) {
                //     $(this).hide();
                //     $(this).parent().prev().hide(); // Sembunyikan header tanggal
                // } else {
                //     $(this).show();
                //     $(this).parent().prev().show(); // Tampilkan header tanggal
                // }
            });
        });
    });
});

$(".dropdown-search").on("hide.bs.dropdown", function () {
    $(".list-date table").show();
    $(".list-date table").parent().prev().show();
    $("input[name=search]").val("");
});

var check_laporan = 0;
$(document).on("click", "input[value=period]", function () {
    check_laporan = 0;
    $(".period-form").prop("hidden", false);
    $(".manual-form").prop("hidden", true);
});

$(document).on("click", "input[value=manual]", function () {
    check_laporan = 1;
    $(".manual-form").prop("hidden", false);
    $(".period-form").prop("hidden", true);
});

$(document).on("change", ".period-select", function () {
    if ($(this).val() == "minggu") {
        $(".time-input").val(1);
        $(".time-input").attr("max", 4);
    } else if ($(this).val() == "bulan") {
        $(".time-input").val(1);
        $(".time-input").attr("max", 11);
    } else if ($(this).val() == "tahun") {
        $(".time-input").val(1);
        $(".time-input").attr("max", 5);
    }
});

$(document).on("click", ".btn-export", function () {
    if (check_laporan == 1) {
        var tgl_awal = $("input[name=tgl_awal_export]").val();
        var tgl_akhir = $("input[name=tgl_akhir_export]").val();
        if (tgl_awal == "" && tgl_akhir == "") {
            swal("", "Tanggal awal dan akhir tidak boleh kosong", "error");
        } else if (tgl_awal == "") {
            swal("", "Tanggal awal tidak boleh kosong", "error");
        } else if (tgl_akhir == "") {
            swal("", "Tanggal akhir tidak boleh kosong", "error");
        } else {
            // var sArray = tgl_awal.split("-");
            // var sDate = new Date(sArray[2], sArray[1], sArray[0]);
            // var eArray = tgl_akhir.split("-");
            // var eDate = new Date(eArray[2], eArray[1], eArray[0]);
            if (tgl_akhir < tgl_awal) {
                swal(
                    "",
                    "Tanggal akhir tidak boleh kurang dari tanggal awal",
                    "error"
                );
            } else {
                $("form[name=export_form]").submit();
            }
        }
    } else {
        $("form[name=export_form]").submit();
    }
});
