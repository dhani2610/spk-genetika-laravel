@extends('layouts.app')

@section('style')
<style>
    .td-karyawan:hover{
        color: black!important
    }
</style>
@endsection

@section('breadcumb')
  <div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ ($breadcumb ?? '') }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">home</li>
                    <li class="breadcrumb-item">/</li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.index') }}">Master Data</a></li>
                    <li class="breadcrumb-item">/</li>
                    <li class="breadcrumb-item active"><a href="{{ route('users.index') }}">{{ ($breadcumb ?? '') }}</a></li>
                </ol>
            </div>

        </div>
    </div>
  </div>
@endsection

@section('content')
<div class="row mt-4">
  <div class="col-12">
    <div class="card">
      <div class="card-header bg-gray1" style="border-radius:10px 10px 0px 0px;">
        <div class="row">
          <div class="col-6 mt-1">
            <span class="tx-bold text-lg text-white" style="font-size:1.2rem;">
              <i class="bx bx-calendar" style="color: white"></i>
              {{ $page_title ?? '' }}
            </span>
          </div>
          <div class="col-6 d-flex justify-content-end">
            @if (Auth::user()->type == 1)
                <a href="{{ route('generateAlgortma') }}" class="btn btn-md btn-info">
                    Generate New Jadwal
                </a>
            @else
                @if ($sisa != 0)
                <a href="{{ route('generateAlgortma') }}" class="btn btn-md btn-warning" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Request Off ({{$sisa}})
                </a>
                @endif
            @endif
           
           

            <!-- Button trigger modal -->

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Isi Form Request Off</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('request-off') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="name">Minggu</label>
                                <select name="week" id="week" class="form-control" required>
                                    <option value="">Pilih Minggu</option>
                                    <option value="1">Minggu 1</option>
                                    <option value="2">Minggu 2</option>
                                    <option value="3">Minggu 3</option>
                                    <option value="4">Minggu 4</option>
                                </select>
                                    <span class="invalid-feedback week" role="alert">
                                        <strong></strong>
                                    </span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">Posisi</label>
                                <input type="text" class="form-control posisi" name="posisi" readonly>
                                    <span class="invalid-feedback week" role="alert">
                                        <strong></strong>
                                    </span>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">Karyawan Pengganti</label>
                                <select name="karyawan_pengganti" id="karyawan_pengganti" class="form-control " required> 
                                </select>
                                    <span class="invalid-feedback week" role="alert">
                                        <strong></strong>
                                    </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-6">
            @include('sweetalert::alert')
          </div>
        </div>
      </div>

      <div class="card-body">
        <table class="table table-bordered dt-responsive" style="width:100%">
            <thead>
                <tr style="background: greenyellow">
                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama Karyawan</th>
                    <th class="text-center">Minggu 1</th>
                    <th class="text-center">Minggu 2</th>
                    <th class="text-center">Minggu 3</th>
                    <th class="text-center">Minggu 4</th>
                </tr>
                <tr>
                    <td>
                        <table style="width:100%" border="1">
                            <tr>
                                <td style="color:white; background: red">
                                    <center>X</center>
                                </td>
                                <td style="color:white; background: blue">
                                    <center>Y</center>
                                </td>
                                <td style="color:white; background: green">
                                    <center>Z</center>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width:100%" border="1">
                            <tr>
                                <td style="color:white; background: red">
                                    <center>X</center>
                                </td>
                                <td style="color:white; background: blue">
                                    <center>Y</center>
                                </td>
                                <td style="color:white; background: green">
                                    <center>Z</center>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width:100%" border="1">
                            <tr>
                                <td style="color:white; background: red">
                                    <center>X</center>
                                </td>
                                <td style="color:white; background: blue">
                                    <center>Y</center>
                                </td>
                                <td style="color:white; background: green">
                                    <center>Z</center>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width:100%" border="1">
                            <tr>
                                <td style="color:white; background: red">
                                    <center>X</center>
                                </td>
                                <td style="color:white; background: blue">
                                    <center>Y</center>
                                </td>
                                <td style="color:white; background: green">
                                    <center>Z</center>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwal as $scheduler)
                <tr>
                    <td style="background: blue;color:white" class="td-karyawan">
                        @php
                            $namaKaryawan = \App\Models\User::where('id',$scheduler->id_karyawan)->first();
                        @endphp
                        {{ $namaKaryawan->name }}
                    </td>
                    <td>
                        <table style="width:100%" border="1">
                            <tr>
                                @php
                                    $posisiArray = explode('_', $scheduler->posisi_w1);
                                @endphp
                                @foreach (['X', 'Y', 'Z'] as $posisi)
                                    <td class="td-karyawan" style="background: {{ in_array($posisi, $posisiArray) ? 'green' : 'red' }}; width:30%; color:white">
                                        <center>
                                            <i class="{{ in_array($posisi, $posisiArray) ? 'fa fa-check' : '' }}">
                                                {{ in_array($posisi, $posisiArray) ? '' : 'Off' }}
                                            </i>
                                        </center>
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width:100%" border="1">
                            <tr>
                                @php
                                    $posisiArray = explode('_', $scheduler->posisi_w2);
                                @endphp
                                @foreach (['X', 'Y', 'Z'] as $posisi)
                                    <td class="td-karyawan" style="background: {{ in_array($posisi, $posisiArray) ? 'green' : 'red' }}; width:30%; color:white">
                                        <center>
                                            <i class="{{ in_array($posisi, $posisiArray) ? 'fa fa-check' : '' }}">
                                                {{ in_array($posisi, $posisiArray) ? '' : 'Off' }}
                                            </i>
                                        </center>
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width:100%" border="1">
                            <tr>
                                @php
                                    $posisiArray = explode('_', $scheduler->posisi_w3);
                                @endphp
                                @foreach (['X', 'Y', 'Z'] as $posisi)
                                    <td class="td-karyawan" style="background: {{ in_array($posisi, $posisiArray) ? 'green' : 'red' }}; width:30%; color:white">
                                        <center>
                                            <i class="{{ in_array($posisi, $posisiArray) ? 'fa fa-check' : '' }}">
                                                {{ in_array($posisi, $posisiArray) ? '' : 'Off' }}
                                            </i>
                                        </center>
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="width:100%" border="1">
                            <tr>
                                @php
                                    $posisiArray = explode('_', $scheduler->posisi_w4);
                                @endphp
                                @foreach (['X', 'Y', 'Z'] as $posisi)
                                    <td class="td-karyawan" style="background: {{ in_array($posisi, $posisiArray) ? 'green' : 'red' }}; width:30%; color:white">
                                        <center>
                                            <i class="{{ in_array($posisi, $posisiArray) ? 'fa fa-check' : '' }}">
                                                {{ in_array($posisi, $posisiArray) ? '' : 'Off' }}
                                            </i>
                                        </center>
                                    </td>
                                @endforeach
                            </tr>
                        </table>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
</body>

        
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$('#example').dataTable();
</script>

<script>
    $(document).ready(function() {
        $('#week').on('change', function() {
            var selectedValue = $(this).val(); // Ambil nilai yang dipilih dari select
            var id_karyawan = '{{ Auth::user()->id }}';
            getDataPosisiWeek(selectedValue,id_karyawan);
        });
        
        function getDataPosisiWeek(selectedValue,id_karyawan) {
            $.ajax({
                url: "{{route('getPosisionWeek')}}", // Ganti dengan URL endpoint yang sesuai di server
                method: 'GET',
                data: { 
                        week: selectedValue,
                        id_karyawan: id_karyawan,
                    },
                success: function(response) {
                    console.log(response);
                    var data = response;
                    if (data.msg == 'berhasil') {
                        $('.posisi').val(data.posisi);

                        getKaryawan(selectedValue,id_karyawan,data.posisi);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function  getKaryawan(selectedValue,id_karyawan,posisi){
            $.ajax({
                url: "{{route('get-karyawan-by-posisi')}}", // Ganti dengan URL endpoint yang sesuai di server
                method: 'GET',
                data: { 
                        week: selectedValue,
                        id_karyawan: id_karyawan,
                        posisi: posisi,
                    },
                success: function(response) {
                    var data = response;
                    console.log(data);
                    if (data.msg == 'berhasil') {

                        // Ambil elemen select
                        var select = $('#karyawan_pengganti');
                        select.empty(); // Kosongkan elemen select sebelum menambahkan opsi baru
                        
                        // Tambahkan opsi default
                        select.append($('<option>', {
                            value: '',
                            text: 'Pilih Karyawan'
                        }));

                        // Tambahkan opsi karyawan dari response
                        $.each(data.karyawan, function (key, value) {
                            select.append($('<option>', {
                                value: value,
                                text: key
                            }));
                        });

                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
    </script>
@endsection