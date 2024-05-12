@extends('layouts.app')

@section('style')

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
              <i class="far fa-user text-lg"></i> 
              {{ $page_title ?? '' }}
            </span>
          </div>

          <div class="col-6 d-flex justify-content-end">
            <a href="{{ route('posisi-create') }}" class="btn btn-md btn-info">
              <i class="fa fa-plus"></i> 
              Add New
            </a>
          </div>
        </div>

        <div class="row">
          <div class="col-6">
            @include('sweetalert::alert')
          </div>
        </div>
      </div>

      <div class="card-body">
        <table id="example" class="table table-hover table-bordered dt-responsive" style="width:100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Karyawan</th>
              <th>Minggu Ke</th>
              <th>Posisi</th>
              <th>Nama Karyawan Pengganti</th>
              {{-- <th>Status</th> --}}
              @if (Auth::user()->type == 1)
              <th>Action</th>
              @endif
            </tr>
          </thead>
          <tbody>

            @foreach ($karyawan as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  @php
                      $namaKaryawan = \App\Models\User::where('id',$item->id_karyawan)->first();
                  @endphp
                  {{ $namaKaryawan->name }}
                </td>
                  @php
                      $cekPosisi = $item->off_1 == 'Pending' ? $item->posisi_before_off_1 : $item->posisi_before_off_2;
                      $pecah = explode("_",$cekPosisi);
                      $week = $pecah[0];
                      $posisi = $pecah[1];
                  @endphp
                <td>
                  {{ 'Minggu '.$week }}
                </td>
                <td>
                  {{$posisi}}
                </td>
                <td>
                  @php
                      $id_karyawan_change = $item->off_1 == 'Pending' ? $item->id_karyawan_change_off_1 : $item->id_karyawan_change_off_2; 
                      $namaKaryawanChange = \App\Models\User::where('id',$id_karyawan_change)->first();
                  @endphp
                  {{ $namaKaryawanChange->name }}
                </td>
                @if (Auth::user()->type == 1)
                <td>
                  <div class="btn-group">
                    <a href="{{ url('approve-off/'. $item->id.'/'.$week.'/'.$posisi) }}" class="btn btn-warning text-white">
                      Approve
                    </a>
                    <a href="{{ url('not-approve-off/'. $item->id.'/'.$week.'/'.$posisi) }}" class="btn btn-danger f-12">
                      Not Approve
                    </a>
                  </div>
                </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$('#example').dataTable();
</script>
@endsection