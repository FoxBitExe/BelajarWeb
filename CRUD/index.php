<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "dblatihan";

    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));
    if(isset($_POST['bsimpan']))
    {
      if($_GET['hal'] == "edit")
      {
        $edit = mysqli_query($koneksi, " UPDATE tmhs set 
                                          peserta = '$_POST[tpeserta]',
                                          nama = '$_POST[tnama]',
                                          alamat = '$_POST[talamat]',
                                          jurusan = '$_POST[tjurusan]'
                                        WHERE id_mhs = '$_GET[id]'
                                        ");

        if($edit)
        {
        echo "<script>
                alert('DATA ANDA TELAH BERHASIL DI RUBAH');
                document.location='index.php';
              </script>";
        }
        else
        {
          echo "<script>
                  alert('DATA ANDA TELAH GAGAL DIRUMAH');
                  document.location='index.php';
                </script>";
        }
      }
      else
      {
        $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (peserta, nama, alamat, jurusan)
        VALUE ('$_POST[tpeserta]', 
              '$_POST[tnama]', 
              '$_POST[talamat]', 
              '$_POST[tjurusan]')
        ");

        if($simpan)
        {
        echo "<script>
                alert('DATA ANDA TELAH TERSIMPAN');
                document.location='index.php';
              </script>";
        }
        else
        {
          echo "<script>
                  alert('DATA ANDA GAGAL TERSIMPAN');
                  document.location='index.php';
                </script>";
        }
      }
      
    }

    if(isset($_GET['hal']))
    {
      if($_GET['hal'] == "edit")
      {
        $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if($data)
        {
          $vpeserta = $data['peserta'];
          $vnama = $data['nama'];
          $valamat = $data['alamat'];
          $vjurusan = $data['jurusan'];
        }
      }
      else if ($_GET['hal'] == "hapus")
      {
        $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
        if($hapus)
          {
            echo "<script>
                    alert('HAPUS DATA SUKSES');
                    document.location='index.php';
                  </script>";
          }
      }

    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BELAJAR CRUD</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="">
</head>

<body>
  <div class="container">
    <h1 class="text-center">BELAJAR CRUD TERBARU</h1>
    <h2 class="text-center">Admin Panel</h2>

    <div class="card mt-3">
      <div class="card-header bg-primary text-white ">
        FORM INPUT DATA
      </div>
      <div class="card-body">
      <form method="post" action="">
          <div class="form-group">
              <label>NOMOR PERSERTA</label>
              <input type="text" name="tpeserta" value="<?=@$vpeserta?>" class="form-control" placeholder="input nim anda disini" required>
          </div>
          <div class="form-group">
            <label>NAMA PESERTA</label>
            <input type="text" name="tnama" value="<?=@$vnama?>"  class="form-control" placeholder="input nama anda disini" required>
          </div>
          <div class="form-group">
            <label>ALAMAT</label>
            <textarea class="form-control" name="talamat" placeholder="inpur alamat anda disni!"><?=@$valamat?></textarea>
          </div>
          <div class="form-group">
            <label>JURUSAN </label>
            <select class="form-control" name="tjurusan">
              <option value="<?=@$vjurusan?>"><?=@$vjurusan?></option>
              <option value="TKJ">TKJ</option>
              <option value="MM">MM</option>
              <option value="RPL">RPL</option>
            </select>
          </div>

          <button type="submit" class="btn btn-success" name="bsimpan">SIMPAN</button>
          <button type="reset" class="btn btn-danger" name="breset">KOSONGKAN</button>

        </form>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header bg-success text-white ">
        DAFTAR MAHASISWA
      </div>
      <div class="card-body">
          <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>NOMOR PESERTA</th>
                <th>NAMA</th>
                <th>ALAMAT</th>
                <th>JURUSAN</th>
                <th>Aksi</th>
            </tr>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
                while($data = mysqli_fetch_array($tampil)) :
            ?>
            <tr>
              <td><?=$no++;?></td>
              <td><?=$data['peserta']?></td>
              <td><?=$data['nama']?></td>
              <td><?=$data['alamat']?></td>
              <td><?=$data['jurusan']?></td>
              <td>
                <a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning"> Edit </a>
                <a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" onclick="return confirm ('APAKAH ANDA YAKIN INGIN MENGHAPUS DATA INI?')" class="btn btn bg-danger"> Hapus </a>
              </td>
            </tr>
            <?php endwhile; ?>
          </table>
      </div>
    </div>

  </div>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>