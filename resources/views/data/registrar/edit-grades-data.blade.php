<div id="edit-grades-data">
    @php
    $data = false;
@endphp
@foreach ($yearLevel as $yl)
<div class="col-md-12 mb-4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-between">
                <div>
                    <h6>AY: {{ $yl->Schedule->schoolYear }}</h6>
                    <h6 class="text-sm">{{ $yl->Schedule->CourseInfo->yearLevel }} - {{ $yl->Schedule->CourseInfo->semester }}</h6>
                    <p class="my-1">Section: {{ $yl->Schedule->section }}</p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-hover text-nowrap mb-4" style="border-bottom: 1px solid rgb(240, 240, 240)">
                    <thead class="text-dark" style="background: rgb(244, 244, 244)">
                        <tr>
                            <th class="text-nowrap"><small>Subject Code</small></th>
                            <th class="text-nowrap"><small>Description</small></th>
                            <th class="text-nowrap"><small>Units</small></th>
                            <th class="text-nowrap"><small>Instructor</small></th>
                            <th class="text-nowrap"><small>MT</small></th>
                            <th class="text-nowrap"><small>FT</small></th>
                            <th class="text-nowrap"><small>AVG</small></th>
                            <th class="text-nowrap"><small>Assessment</small></th>
                            <th class="text-nowrap"><small>Action</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalUnits = 0;
                            $totalAvg = 0;
                            $count = 0;
                            $mtValues = [];
                            $ftValues = [];
                            $avgValues = [];
                            $subjectCodes = [];
                        @endphp
                        @foreach ($studentGrading->where('studentYearLevelID', $yl->id) as $sub)
                        <tr>
                            <td
                            id="{{ $aes->encrypt($student->id) }}"
                            gradeID="{{ $aes->encrypt($sub->id) }}"
                            mt="{{ $sub->mt }}"
                            ft="{{ $sub->ft }}"
                            nc="{{ $sub->Subjects->NC }}"
                            assessment="{{ $sub->assessment }}"
                            ><small>{{ $sub->Subjects->subjectCode }}</small></td>
                            <td><small>{{ $sub->Subjects->description }}</small></td>
                            <td><small>{{ $sub->Subjects->units }}</small></td>
                            <td><small>{{ $sub->Instructors->instructor }}</small></td>
                            <td>
                                <div>
                                    <small class="">
                                        {{ $sub->mt }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <small class="">
                                        {{ $sub->ft }}
                                        </small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <small class="fw-bold">
                                        {{ $sub->avg }}
                                        </small>
                                </div>
                            </td>
                            <td>
                                <small>
                                    @if($sub->Subjects->NC == 0)
                                        <span style="font-size: 12px">None</span>
                                    @else
                                        @if($sub->assessment == 0)
                                            <i class="fa-solid fa-circle-check text-primary fw-bold"></i> <span class="ms-1" style="font-size: 12px">Not Yet Taken</span>
                                        @endif
                                        @if($sub->assessment == 1)
                                            <i class="fa-solid fa-circle-check text-success fw-bold"></i> <span class="ms-1" style="font-size: 12px">COMPETENT</span>
                                        @endif
                                        @if($sub->assessment == 2)
                                            <i class="fa-solid fa-circle-xmark text-danger fw-bold"></i> <span class="ms-1" style="font-size: 12px">NOT YET COMPETENT</span>
                                        @endif
                                    @endif
                                </small>
                            </td>
                            <td>
                                <small>
                                    @if($student->diploma == null)
                                    <a href="javascript:;" id="edit-grades-value" class="">
                                        <i class="fas fa-marker"></i>
                                    </a>
                                    @else
                                    -
                                    @endif
                                </small>
                            </td>
                        </tr>
                        @php
                            $totalUnits += $sub->Subjects->units;
                            if ($sub->avg != 0) {
                                $totalAvg += $sub->avg;
                                $count++;
                            }
                            $mtValues[] = $sub->mt;
                            $ftValues[] = $sub->ft;
                            $avgValues[] = $sub->avg;
                            $subjectCodes[] = $sub->Subjects->subjectCode;
                        @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end"><small><strong>Total Units:</strong></small></td>
                            <td><small><strong>{{ $totalUnits }}</strong></small></td>
                            <td colspan="2" class="text-end"><small><strong>GWA:</strong></small></td>
                            <td><small><strong>{{ $count > 0 ? number_format($totalAvg / $count, 2) : '0.0' }}</strong></small></td>
                        </tr>
                    </tfoot>
                </table>
                
                <!-- Chart Container -->
                <div id="chart-{{ $yl->id }}" class="overflow-hidden"></div>
                
               
            <!--    <script>
                   
                    $(document).ready(function() {
                        const mtValues = @json($mtValues);
                        const ftValues = @json($ftValues);
                        const avgValues = @json($avgValues);

                        // Find the maximum value to calculate inverted values
                        const maxValue = Math.max(...mtValues, ...ftValues, ...avgValues);

                        // Invert the values and round them to a reasonable precision (e.g., 2 decimal places)
                        const invertedMtValues = mtValues.map(value => Math.round((maxValue - value) * 100) / 100);
                        const invertedFtValues = ftValues.map(value => Math.round((maxValue - value) * 100) / 100);
                        const invertedAvgValues = avgValues.map(value => Math.round((maxValue - value) * 100) / 100);

                        var options = {
                            chart: {
                                type: 'area',
                                height: 300,
                                
                            },
                            series: [
                                {
                                    name: 'MT',
                                    data: invertedMtValues
                                },
                                {
                                    name: 'FT',
                                    data: invertedFtValues
                                },
                                {
                                    name: 'AVG',
                                    data: invertedAvgValues
                                }
                            ],
                            xaxis: {
                                categories: @json($subjectCodes),
                            },
                            tooltip: {
                                shared: true,
                                intersect: false,
                                y: {
                                    formatter: function(value, { series, seriesIndex, dataPointIndex, w }) {
                                        // Show the original value in the tooltip
                                        if (seriesIndex === 0) return `${mtValues[dataPointIndex]}`;
                                        if (seriesIndex === 1) return `${ftValues[dataPointIndex]}`;
                                        if (seriesIndex === 2) return `${avgValues[dataPointIndex]}`;
                                    }
                                }
                            },
                            dataLabels: {
                                enabled: true,
                                formatter: function(val, { seriesIndex, dataPointIndex, w }) {
                                    // Display original values as data labels
                                    if (seriesIndex === 0) return mtValues[dataPointIndex];
                                    if (seriesIndex === 1) return ftValues[dataPointIndex];
                                    if (seriesIndex === 2) return avgValues[dataPointIndex];
                                },
                            },
                            markers: {
                                size: 5,
                                hover: {
                                    size: 7
                                }
                            },
                            legend: {
                                position: 'bottom'
                            },
                            
                            plotOptions: {
                                area: {
                                    fillTo: 'origin', // Ensures that the area is filled from the baseline
                                },
                            },
                        };

                        var chart = new ApexCharts(document.querySelector("#chart-{{ $yl->id }}"), options);
                        chart.render();
                    });
                
                </script> -->
                
            </div>
        </div>
    </div>
</div>
@php
    $data = true;
@endphp
@endforeach

@if($data == false)
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header text-center">
                    <p class="my-0">No Grades Yet</p>
                </div>
            </div>
        </div>
    </div>
@endif

</div>