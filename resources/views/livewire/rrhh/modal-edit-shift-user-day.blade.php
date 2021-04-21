<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

       <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">Modificar día de personal</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">×</span>

                </button>

            </div>

            <div class="modal-body">

                <form>

                    <div class="form-group">

                        <input type="hidden" wire:model="user_id">

                        <label for="exampleFormControlInput1">Información</label>
                        <table class="table"> 
                        <thead> 
                            <tr>
                                <th>Pertence a</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Tipo de jornada</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Fecha</th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Estado</th>
                                <td></td>
                            </tr>
                        </thead>
                         
                        </table>
                    </div>

                    <div class="form-group">

                        <input type="hidden" wire:model="user_id">

                        <label for="exampleFormControlInput1">Name</label>

                        <input type="text" class="form-control" wire:model="name" id="exampleFormControlInput1" placeholder="Enter Name">

                        <span class="text-danger"></span>

                    </div>


                </form>

            </div>

            <div class="modal-footer">

                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Save changes</button>

            </div>

       </div>

    </div>

</div>