<div class="modal fade" id="exampleModal-exp-{{ $experience->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Experiencia Laboral: </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          @foreach($replacementStaff->experiences->Where('id', $experience->id) as $modal_experience)

              <h5>Experiencia Laboral:</h5>
              <p>{{ $modal_experience->previous_experience }}</p>
              <h5>Funciones Realizadas:</h5>
              <p>{{ $modal_experience->performed_functions }}</p>
              <h5>Certificado de Experiencia:</h5>
              <a href="{{ route('replacement_staff.experience.show_file', $experience) }}"
                  class="btn btn-outline-secondary btn-sm"
                  title="Ir"
                  target="_blank"> <i class="far fa-eye"></i></a>
              <a class="btn btn-outline-secondary btn-sm"
                  href="{{ route('replacement_staff.experience.download', $experience) }}"
                  target="_blank"><i class="fas fa-download"></i>
              </a>
              <h5>Nombre Contacto:</h5> {{ $modal_experience->contact_name }} - {{ $modal_experience->contact_telephone }}


          @endforeach
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary float-right">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>
