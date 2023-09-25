<div>
    <div class="table-responsive">
        <table class="table table-bordered table-sm small">
            <thead>
                <tr class="text-center table-secondary">
                    <th width="">Id</th>
                    <th></th>
            </thead>
            <tbody>
                @foreach($purchasePlans as $purchasePlan)
                <tr class="text-center">
                    <td>{{ $purchasePlan->id }}</td>
                    <td>
                        {{--
                        <a href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff) }}"
                            class="btn btn-outline-secondary btn-sm"><i class="fas fa-calendar-alt"></i>
                        --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
