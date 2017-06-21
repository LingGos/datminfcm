$(document).ready(function() {
    
    var datacleaning;
    var datanormal;
    $("#data-btncleaning").on('click', (function(e) {
        e.preventDefault();
        $('#data-btncleaning-proses').removeClass('hide');
        $('#data-btncleaning-awal').addClass('hide');
        $('#data-btncleaning').addClass('disabled');
        $.ajax({
            url: "Controller/Cluster.php?task=cleaning",
            contentType: false,
            dataType: "json",
            cache: false,
            processData: false,
            success: function(data)
            {
                $(".tab-data-cluster").removeClass("active");
                $(".tabcontent-data-cluster").removeClass("active");
                $(".tab-cleaning-cluster").addClass("active");
                $(".tabcontent-cleaning-cluster").addClass("active");

                datacleaning = data;
                html = "";
                for (var a = 0; a < datacleaning.length; a++) {
                    html = html + "<tr>";
                    html = html + "<td class='center blue'>" + (a + 1) + "</td>";
                    html = html + "<td class='center blue'>" + datacleaning[a].trbKodeBuku + "</td>";
                    html = html + "<td class='center blue'>" + datacleaning[a].trbJmlStok + "</td>";
                    html = html + "<td class='center blue'>" + datacleaning[a].trbJmlDiminati + "</td>";
                    html = html + "<td class='center blue'>" + datacleaning[a].trbJmlAnggota + "</td>";
                    html = html + "</tr>";
                }
                $('#myBodyTableCleaningCluster').append($(html));
            }
        });

    }));

    $("#cleaning-btnnormalisasi").on('click', (function(e) {
        e.preventDefault();

        $('#cleaning-btnnormalisasi-proses').removeClass('hide');
        $('#cleaning-btnnormalisasi-awal').addClass('hide');
        $('#cleaning-btnnormalisasi').addClass('disabled');
        $.ajax({
            url: "Controller/Cluster.php?task=normalisasi",
            contentType: false,
            dataType: "json",
            cache: false,
            processData: false,
            success: function(data)
            {
                $(".tab-cleaning-cluster").removeClass("active");
                $(".tabcontent-cleaning-cluster").removeClass("active");
                $(".tab-normalisasi-cluster").addClass("active");
                $(".tabcontent-normalisasi-cluster").addClass("active");
                datanormal = data;

                html = "";
                for (var a = 0; a < datanormal.length; a++) {
                    html = html + "<tr>";
                    html = html + "<td class='center blue'>" + (a + 1) + "</td>";
                    html = html + "<td class='center blue'>" + datanormal[a].KODE + "</td>";
                    html = html + "<td class='center blue'>" + datanormal[a].X1 + "</td>";
                    html = html + "<td class='center blue'>" + datanormal[a].X2 + "</td>";
                    html = html + "<td class='center blue'>" + datanormal[a].X3 + "</td>";
                    html = html + "</tr>";
                }
                $('#myBodyTableNormalCluster').append($(html));
            }
        });

    }));

    $("#normalisasi-btninizialisasi").on('click', (function(e) {
        e.preventDefault();
        $('#normalisasi-btninizialisasi-proses').removeClass('hide');
        $('#normalisasi-btninizialisasi-awal').addClass('hide');
        $('#normalisasi-btninizialisasi').addClass('disabled');

        $(".tab-normalisasi-cluster").removeClass("active");
        $(".tabcontent-normalisasi-cluster").removeClass("active");
        $(".tab-inisialisasi-cluster").addClass("active");
        $(".tabcontent-inisialisasi-cluster").addClass("active");

    }));

    $("#formx-inisialisasi-cluster").on('submit', (function(e) {
        e.preventDefault();
//        alert('asas');die();
        var nc = $('select[name="nc"]').val();
        var fo = $('input[name="fo"]').val();
        var mi = $('input[name="mi"]').val();

        if (!nc && !fo && !mi) {
            alert('Data Tidak Boleh Ada Yang Kosong !!');
        } else {
            $('#inisialisasi-btnhasilfcm-proses').removeClass('hide');
            $('#inisialisasi-btnhasilfcm-awal').addClass('hide');
            $('#inisialisasi-btnhasilfcm').addClass('disabled');

            $.ajax({
                url: "Controller/Cluster.php?task=fcm",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: "json",
                cache: false,
                processData: false,
                success: function(data)
                {
                    $(".tab-inisialisasi-cluster").removeClass("active");
                    $(".tabcontent-inisialisasi-cluster").removeClass("active");
                    $(".tab-hasil-cluster").addClass("active");
                    $(".tabcontent-hasil-cluster").addClass("active");
//                    console.log(data);
                    if (data.status) {
                        alert('Semua Data Berhasil Dicluster..');
                        $('input[name="jml_cls"]').val(data.atribut_awal.nc)
                        $('input[name="max_itr"]').val(data.atribut_awal.mi)
                        $('input[name="min_err"]').val(data.atribut_awal.fo)
                        $('input[name="fo"]').val(data.atribut_fcm.fo)
                        $('input[name="itr"]').val(data.atribut_fcm.iterasi);

                        html = "<thead><tr><th class='center blue'>No</th>";
                        html = html + "<th class='center blue'>Kode Buku</th>";
                        for (var a = 0; a < data.partisi_awal[0].length; a++) {
                            html = html + "<th class='center blue'>C" + (a + 1) + "</th>";
                        }
                        html = html + "</thead></tr>";
                        html = html + "<tbody>";
                        for (var a = 0; a < data.partisi_awal.length; a++) {
                            html = html + "<tr>";
                            html = html + "<td class='center blue'>" + (a + 1) + "</td>";
                            html = html + "<td class='center blue'><b>" + data.data_normal[a].KODE + "<b></td>";
                            for (var aa = 0; aa < data.partisi_awal[0].length; aa++) {
                                html = html + "<td class='center'><b>" + data.partisi_awal[a][aa] + "<b></td>";
                            }
                            html = html + "</tr>";
                        }
                        html = html + "</tbody>";
                        $('.myBodyTablePartisiAwalCluster').append($(html));


                        html = "<thead><tr><th class='center blue'>No</th>";
                        html = html + "<th class='center blue'>Kode Buku</th>";
                        for (var a = 0; a < data.partisi_awal_normal[0].length; a++) {
                            html = html + "<th class='center blue'>C" + (a + 1) + "</th>";
                        }
                        html = html + "</thead></tr>";
                        html = html + "<tbody>";
                        for (var a = 0; a < data.partisi_awal_normal.length; a++) {
                            html = html + "<tr>";
                            html = html + "<td class='center blue'>" + (a + 1) + "</td>";
                            html = html + "<td class='center blue'><b>" + data.data_normal[a].KODE + "<b></td>";
                            for (var aa = 0; aa < data.partisi_awal_normal[0].length; aa++) {
                                html = html + "<td class='center'><b>" + data.partisi_awal_normal[a][aa] + "<b></td>";
                            }
                            html = html + "</tr>";
                        }
                        html = html + "</tbody>";
                        $('.myBodyTablePartisiAwalNormalCluster').append($(html));

                        html = "<thead><tr><th class='center blue'>No</th>";
                        for (var a = 0; a < data.pc[0].length; a++) {
                            html = html + "<th class='center blue'>X" + (a + 1) + "</th>";
                        }
                        html = html + "</thead></tr>";
                        html = html + "<tbody>";
                        for (var a = 0; a < data.pc.length; a++) {
                            html = html + "<tr>";
                            html = html + "<td class='center blue'>C" + (a + 1) + "</td>";
                            for (var aa = 0; aa < data.pc[0].length; aa++) {
                                html = html + "<td class='center'><b>" + data.pc[a][aa] + "<b></td>";
                            }
                            html = html + "</tr>";
                        }
                        html = html + "</tbody>";
                        $('.myBodyTablePusatClusterCluster').append($(html));


                        html = "<thead><tr><th class='center blue'>No</th>";
                        html = html + "<th class='center blue'>Kode Buku</th>";
                        for (var a = 0; a < data.partisi[0].length; a++) {
                            html = html + "<th class='center blue'>C" + (a + 1) + "</th>";
                        }
                        html = html + "</thead></tr>";
                        html = html + "<tbody>";
                        for (var a = 0; a < data.partisi.length; a++) {
                            html = html + "<tr>";
                            html = html + "<td class='center blue'>" + (a + 1) + "</td>";
                            html = html + "<td class='center blue'><b>" + data.data_normal[a].KODE + "<b></td>";
                            for (var aa = 0; aa < data.partisi[0].length; aa++) {
                                html = html + "<td class='center'><b>" + data.partisi[a][aa] + "<b></td>";
                            }
                            html = html + "</tr>";
                        }
                        html = html + "</tbody>";
                        $('.myBodyTablePartisiAkhirCluster').append($(html));


                    } else {
                        alert('Semua Data Gagal Dicluster..');
                        window.location.href = 'admin.php?modul=cluster';
                    }
                }
            });
        }
    }));
    $("#hasil-btnhasilview").on('click', (function(e) {
        e.preventDefault();
        $('#hasil-btnhasilview-proses').removeClass('hide');
        $('#hasil-btnhasilview-awal').addClass('hide');
        $('#hasil-btnhasilview').addClass('disabled');
        
        
        $.ajax({
                url: "Controller/Cluster.php?task=hasil",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: "json",
                cache: false,
                processData: false,
                success: function(data)
                {
                    $(".tab-hasil-cluster").removeClass("active");
                    $(".tabcontent-hasil-cluster").removeClass("active");
                    $(".tab-hasil-cluster-view").addClass("active");
                    $(".tabcontent-hasil-cluster-view").addClass("active");
                        $('input[name="hjml_cls"]').val(data.hjml_cls)
                        $('input[name="hwkt_cls"]').val(data.hwkt_cls)
                        $('input[name="htot_cls"]').val(data.htot_cls)
                        
                        html = "<thead><tr><th class='center blue'>Cluster</th><th class='center blue'>Total Data</th>";
                        for (var a = 0; a < data.kode.length; a++) {
                            html = html + "<th class='center blue'>" + data.kode[a] + "</th>";
                        }
                        html = html + "</tr></thead><tbody><tr>";
                        
                        for (var aa = 0; aa < data.datajml.length; aa++) {
                            html = html + "<td class='center blue'>" + data.datajml[aa] + "</td>";
                        }
                        html = html + "<td class='center blue'>Jumlah</td><td class='center blue'>"+data.htot_cls+"</td></tr>";
                        $('.hasilcluster1x').append($(html));

                        
                        html = "<thead><tr><th class='center blue'>No</th>";
                        html = html + "<th class='center blue'>Kode Buku</th><th class='center blue'>Nama Buku</th><th class='center blue'>Topik Buku</th><th class='center blue'>Cluster</th><th class='center blue'>Saran Lama Peminjaman</th><th class='center blue'>Keterangan</th>";
                        html = html + "</thead></tr>";
                        html = html + "<tbody>";
                        for (var a = 0; a < data.datatampil.length; a++) {
                            html = html + "<tr>";
                            html = html + "<td class='center blue'>" + (a + 1) + "</td>";
                            html = html + "<td class='center blue'>" + data.datatampil[a].trbKodeBuku + "</td>";
                            html = html + "<td class='center blue'>" + data.datatampil[a].trbNamaBuku + "</td>";
                            html = html + "<td class='center blue'>" + data.datatampil[a].trbTopikBuku + "</td>";
                            html = html + "<td class='center blue'>" + data.datatampil[a].krcKode + "</td>";
                            html = html + "<td class='center blue'>" + data.datatampil[a].krcLama + "</td>";
                            html = html + "<td class='center blue'>" + data.datatampil[a].krcNama + "</td>";
                            html = html + "</tr>";
                        }
                        html = html + "</tbody>";
                        $('.tableasilview').append($(html));
                }
            });
            
    }));

})
