
<div>
   <div wire:loading>
              <i class="fas fa-spinner fa-pulse"></i>
        </div>

    @if(isset($staffInShift)&&count($staffInShift)>0&&$staffInShift!="")
        @foreach($staffInShift as $sis)
            <tr>
                <td class="bless br cellbutton" >
                    
                    @livewire( 'rrhh.see-shift-control-form', ['usr'=>$sis->user, 'actuallyYears'=>$actuallyYear,'actuallyMonth'=>$actuallyMonth], key($loop->index) )

                   {{ $sis->user->runFormat()}} - {{$sis->user->name}} {{$sis->user->fathers_family}} 
      
                </td>
                @for($j = 1; $j <= $days; $j++) 
                    @php
                        $date = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$j);  
                        $date =explode(" ",$date);
                        $d = $sis->days->where('day',$date[0]);
                    @endphp
                    <td class="bbd day cellbutton"  style="text-align:center;width:54px;height:54px">
                            @if(isset($d) && count($d) )
                               @livewire('rrhh.change-shift-day-status',['shiftDay'=>$d->first()],key($d->first()->id) )
                            @else
                               
                               <i data-toggle="modal" data-target="#newDatModal"  data-keyboard= "false" data-backdrop= "static"  style="color:green;font-weight: bold;font-size:20px" class="fa fa-plus btnShiftDay">
                                </i>
                              
                            @endif
                        
                    </td>
                @endfor    
            </tr>   
        @endforeach
        
        @else                           
            <td style="text-align:  center;" colspan="{{$days}}">SIN PERSONAL ASIGNADO</td>
        @endif

</div>


