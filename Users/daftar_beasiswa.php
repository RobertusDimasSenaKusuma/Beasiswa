<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Beasiswa</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* Body dan container */
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            margin-top: 50px;
        }

        /* Card dengan border halus dan bayangan ringan */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Styling tombol */
        .btn-success, .btn-secondary {
            border-radius: 20px;
            width: 48%; /* Lebar tombol agar proporsional */
        }

        /* Tombol submit & reset sejajar rapi */
        .button-group {
            gap: 15px; /* Jarak antar tombol */
        }

       
        /* Header lebih besar */
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Sticky dan styling header tabel */
        thead th {
            position: sticky;
            top: 0;
            background-color: #6c757d; /* Warna abu-abu */
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

       
        
    </style>
    </style>
</head>
    <?php include 'Navbar_User.php'; ?> <!-- Navbar Include -->
<body>

    

    <div class="container form-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-10">
                        <h4 class="text-center mb-4">Form Pendaftaran Beasiswa</h4>
                        <form id="beasiswaForm" action="submit.php" method="POST" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="hp" class="form-label">Nomor HP</label>
                                    <input type="text" name="hp" id="hp" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="semester" class="form-label">Semester</label>
                                    <input type="text" name="semester" id="semester" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="ipk" class="form-label">IPK Terakhir</label>
                                    <input type="text" name="ipk" id="ipk" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="berkas" class="form-label">Upload Berkas Syarat</label>
                                    <input type="file" name="berkas" id="berkas" class="form-control" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="beasiswa1" class="form-label">Beasiswa Akademik</label>
                                    <select name="beasiswa1" id="beasiswa1" class="form-select" required>
                                        <option value="">Pilih Beasiswa Akademik</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="beasiswa2" class="form-label">Beasiswa Non-Akademik</label>
                                    <select name="beasiswa2" id="beasiswa2" class="form-select" required>
                                        <option value="">Pilih Beasiswa Non-Akademik</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between button-group mt-4">
                                <button type="submit" class="btn btn-success">Daftar</button>
                                <button type="reset" class="btn btn-secondary">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi AJAX untuk mengambil data beasiswa
        function loadBeasiswa(kategori, targetSelect) {
            $.ajax({
                url: 'get_data.php',
                method: 'POST',
                data: { kategori: kategori },
                dataType: 'json',
                success: function(response) {
                    $(targetSelect).empty().append('<option value="">Pilih Beasiswa</option>');
                    if (response.beasiswa.success) {
                        $.each(response.beasiswa.data, function(index, beasiswa) {
                            $(targetSelect).append('<option value="' + beasiswa.nama + '">' + beasiswa.nama + '</option>');
                        });
                    } else {
                        alert(response.beasiswa.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil data beasiswa.');
                }
            });
        }

        // Load data beasiswa saat halaman dimuat
        $(document).ready(function() {
            loadBeasiswa('akademik', '#beasiswa1');
            loadBeasiswa('non akademik', '#beasiswa2');
        });
        // Mengambil data user saat nama diinput
$('#nama').on('blur', function() {
    var nama = $(this).val();
    if (nama !== '') {
        $.ajax({
            url: 'get_data.php',
            method: 'POST',
            data: { nama: nama },
            dataType: 'json',
            success: function(response) {
                if (response.user.success) {
                    $('#email').val(response.user.data.email);
                    $('#hp').val(response.user.data.nomor_hp);
                    $('#semester').val(response.user.data.semester);
                    $('#ipk').val(response.user.data.ipk);

                    // Check IPK value
                    if (parseFloat(response.user.data.ipk) < 3.00) {
                        alert('Anda tidak memenuhi syarat untuk mendaftar beasiswa. IPK Anda harus 3.00 atau lebih.');
                        // Optionally, disable the submit button
                        $('button[type="submit"]').prop('disabled', true);
                    } else {
                        // Enable the submit button if IPK is valid
                        $('button[type="submit"]').prop('disabled', false);
                    }
                } else {
                    alert(response.user.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat mengambil data user.');
            }
        });
    }
});

// Validasi agar kedua beasiswa dipilih
$('#beasiswaForm').on('submit', function(e) {
    if ($('#beasiswa1').val() === '' || $('#beasiswa2').val() === '') {
        alert('Anda harus memilih 1 beasiswa akademik dan 1 non-akademik.');
        e.preventDefault();
    }
});

        
        
    </script>

</body>
</html>
