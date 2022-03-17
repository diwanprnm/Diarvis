<?php 
header('Content-Type: application/pdf'); 
header('Content-Description: inline; filename.pdf'); 
?>
<div class="body">

<table class="header">
    <tr>
        <td style="width:10%">
        <img src="{{ $reportdata['img'] }}" style="width:100px" />
                                                              
    </td>
        <td style="width:90%;text-align:center"><p style="header1">Pemerintah Kabupaten Bandung</p>
<p style="header2"><b>DAFTAR RENCANA KEBUTUHAN BARANG UNIT (DRKBU)</b></p> 
<p style="header3">Tahun Anggaran 2021</p>

        </td>
    </tr>
</table>

<table class="table">
    <tr><td>Bidang</td><td>: {{ $reportdata['bidang']}}</td></tr>
    <tr><td>Unit Organisasi</td><td>: {{ $reportdata['nama_unit']}} </td></tr>
    <tr><td>Sub Unit</td><td>: {{ $reportdata['nama_sub_unit']}} </td></tr>
    <tr><td>Kab / Kota</td><td>: {{ $reportdata['nama_kab_kota']}} </td></tr>
    <tr><td>Provinsi</td><td>: {{ $reportdata['provinsi']}} </td></tr>
 

</table>
<table class="table-border">
                        <thead>
                            <tr>
                                <th class="w5" >No</th>
                                <th class="w30" >Nama / Jenis Barang</th>
                                <th class="w10" >Merk / Type Ukuran</th>
                                <th class="w10" >Jumlah Barang</th>
                                <th class="w10" >Harga Satuan(Rp)</th>
                                <th class="w10" >Jumlah Biaya (Rp)</th>
                                <th class="w15" >Kode Rekening</th>
                                <!-- <th>Foto</th> -->
                                <th>Keterangan</th>
                            </tr>
                            <tr>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                                <th>5</th>
                                <th>6</th>
                                <th>7</th>
                                <!-- <th>Foto</th> -->
                                <th>8</th>
                            </tr>
                        </thead>
                        <tbody >
                        @foreach ($trkb as $data)
                        <tr>
                                <td >{{$loop->index + 1}}</td>
                                <td style="text-align:left;margin-left:15px;">{{$data->nama_aset_5}}</td>
                                <td>{{ $data->merk }}</td>
                                <td>{{ $data->jumlah }}</td>
                                <td>{{ $data->harga }}</td>
                                <td>{{ $data->harga }}</td>
                                <td>5,2,3,26</td>
                                <!-- <th>Foto</th> -->
                                <td></td>
                            </tr>
                        @endforeach    
                        </tbody>
                    </table> 
 
                    <table class="footer">
                    <tr>
                                <td class="w90"> </td>
                                <td class="w10">{{ $reportdata['tanggal_laporan']}} </td>
                        </tr>
                    <tr>
                                <td class="w90"> </td>
                                <td class="w10">{{ $reportdata['nama_sub_unit']}} </td>
                        </tr>
                        <tr><td class="w80"> </td><td class="w10"></td>  </tr>
                        <tr><td class="w80"> </td><td class="w10"></td>  </tr><tr><td class="w80"> </td><td class="w10"></td>  </tr>
                        <tr><td class="w80"> </td><td class="w10"></td>  </tr>
                        <tr>
                                <td class="w80"> </td>
                                <td class="w10">.................... </td>
                        </tr>
                        <tr>
                                <td class="w80"> </td>
                                <td class="w10">NIP.  </td>
                        </tr>
                    </table>
                        
</div>