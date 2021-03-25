<div>

  <a data-toggle="modal" data-target="#exampleModal{{$data[array_key_first($data)]->id}}" class="btn btn-outline-secondary btn-sm">
    <i class="far fa-eye"></i>
  </a>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal{{$data[array_key_first($data)]->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-sm small table-striped" >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CANTIDAD</th>
                </tr>
            </thead>
            @foreach($data as $key => $row)
              <tr>
                <td>{{$key}}</td>
                <td>{{$row->name}}</td>
              </tr>
            @endforeach
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>
