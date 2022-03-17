@foreach ($data as $no => $item)
<page size = "A4">
    <div class="row">
        <div class="col-12 mt-3">
            @php
            if($item->id == 1){
                $role = 'Mandor - UPTD 1';
                $role_id = 52;
            }else if($item->id == 2){
                $role = 'Mandor - UPTD 2';
                $role_id = 91;
            }else if($item->id == 3){
                $role = 'Mandor - UPTD 3';
                $role_id = 61;
            }else if($item->id == 4){
                $role = 'Mandor - UPTD 4';
                $role_id = 70;
            }else if($item->id == 5){
                $role = 'Mandor - UPTD 5';
                $role_id = 77;
            }else if($item->id == 6){
                $role = 'Mandor - UPTD 6';
                $role_id = 84;
            }
           
            @endphp
            <p class=" font-weight-bold">Detail UPTD {{ $item->id }}</p>
            <table class="table table-sm table-bordered" >
                <thead class="text-center">
                    <tr class="text-center">
                        <th class="align-middle">SPPJJ</th>
                        <th class="align-middle">MANDOR</th>
                        <th class="align-middle">RUAS</th>
                        <th class="align-middle">ENTRY</th>
                        <th class="align-middle">TOTAL</th>
                        {{-- <th class="align-middle">TERAKHIR ENTRY</th> --}}
                    </tr>
                    
                </thead>
                <tbody>
                    @foreach ($item->library_sup as $sup)
                        <tr>
                            <td rowspan="{{ count($sup->library_ruas) }}">{{ $sup->name }}</td>
                            <td rowspan="{{ count($sup->library_ruas) }}" class="text-center">{{ count($sup->library_user->where('internal_role_id',$role_id)) }}</td>
                            <td>{{ $sup->library_ruas[0]->nama_ruas_jalan }}</td>
                            <td class="text-center">{{ count($sup->library_ruas[0]->library_pemeliharaan->whereBetween('tanggal', [$filter['tanggal_awal'] , $filter['tanggal_akhir'] ])) }}</td>
                            
                            <td  class="text-center align-middle" rowspan="{{ count($sup->library_ruas) }}">{{ count($sup->library_pemeliharaan->whereBetween('tanggal', [$filter['tanggal_awal'] , $filter['tanggal_akhir'] ])) }}</td> 

                        </tr>
                        @for ($m=1 ; $m < count($sup->library_ruas) ;$m++)
                        
                        <tr>
                            <td>{{ $sup->library_ruas[$m]->nama_ruas_jalan }}</td>
                            <td class="text-center">{{ count($sup->library_ruas[$m]->library_pemeliharaan->whereBetween('tanggal', [$filter['tanggal_awal'] , $filter['tanggal_akhir'] ])) }}</td>
                        </tr>
                            
                        @endfor
                    @endforeach
                    
                </tbody>
            </table>
    
        </div>
    </div>
</page>
@endforeach