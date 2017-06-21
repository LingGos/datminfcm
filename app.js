/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $(".btn-ubah-kunci").on('click', function (e) {
        var id = $(this).attr('id');
        var pass = $(this).attr('pass');
        $('#modal-form-ubah-pass').appendTo("body").modal('show');
        $('#id').val(id);
        $('#pass').val(pass);
        $('#passLama').val(null);
        $('#passBaru1').val(null);
        $('#passBaru2').val(null);
    });

    $('#form-ubah-pass').on('submit', function (e) {
        e.preventDefault();
        var id = $('#id').val();
        var pass = $('#pass').val();
        var passlama = $('#passLama').val();
        var passbaru1 = $('#passBaru1').val();
        var passbaru2 = $('#passBaru2').val();
        if (pass != passlama) {
            //mesage password baru tdak sama
            alert("Password Lama Tidak Sesuai");
            window.location.href = 'admin.php';
        } else {
            if (passbaru1 != passbaru2) {
                //mesage password baru tdak sama
                alert("Password Baru Tidak Sesuai");
                window.location.href = 'admin.php';
            } else {
                $.ajax({
                    url: "Controller/UbahPassword.php",
                    type: "POST",
                    data: "id=" + id + "&passbaru=" + passbaru1,
                    dataType: "json",
                    success: function (data) {
                        if (data) {
                            alert("Password Berhasil Diubah");
                            window.location.href = 'admin.php';
                        } else {
                            alert("Password Gagal Diubah");
                            window.location.href = 'admin.php';
                        }
                    }
                });
            }
        }
    });

});