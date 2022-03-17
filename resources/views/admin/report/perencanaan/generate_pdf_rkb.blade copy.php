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
    <tr><td>Unit Organisasi</td><td>:{{ $reportdata['nama_unit']}} </td></tr>
    <tr><td>Sub Unit</td><td>: </td></tr>
    <tr><td>Kab / Kota</td><td>: </td></tr>
    <tr><td>Provinsi</td><td>: </td></tr>
 

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
                        <tr>
                                <td>1</td>
                                <td>Gedung Kantor Permanen</td>
                                <td>A</td>
                                <td>1</td>
                                <td>2.000.000.000</td>
                                <td>2.000.000.000</td>
                                <td>5,2,3,26</td>
                                <!-- <th>Foto</th> -->
                                <td></td>
                            </tr>
                        </tbody>
                    </table> 
 
                    <table class="footer">
                    <tr>
                                <td class="w90"> </td>
                                <td class="w10">{{ $reportdata['nama_unit']}} </td>
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