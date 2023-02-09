@php
    $user = auth()->user();
@endphp

@extends('layouts/contentLayoutMaster')

@section('title', 'Curva de Crec.(Peso, Talla, IMC, Perímetro Encefálico)')

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 margin-tb">

            <div class="col-12">
                <a class="btn btn-primary float-end" href="{{ route('pacientes.index') }}"> Regresar a Pacientes</a>
            </div>
        </div>
    </div>

    <br>
    <div class="card text-start">
        <div class="card-body">
            <h4 class="card-title">Datos de Usuario</h4>
            <p class="card-text">Paciente: {{ $pac->name }}</p>
            <p class="card-text">Nacimiento: {{ $pac->nacimiento }}</p>
            <p class="card-text">Género: {{ $pac->genero }}</p>

        </div>
    </div>

    <section>

        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-primary float-start" data-bs-toggle="modal"
                    data-bs-target="#exampleModalMasa">
                    Registro de Antropometría
                </button>
            </div>
        </div>
        <br>
        @if ($pac->genero == 'Masculino')
            <!--Boy-->
            <div class="card">
                <div class="card-body">
                    <canvas id="PesoEdad"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <canvas id="TallaEdad"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <canvas id="imc_edad"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <canvas id="perim_edad"></canvas>
                </div>
            </div>
        @else
            <!--Girl-->
            <div class="card">
                <div class="card-body">
                    <canvas id="peso_girl"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <canvas id="talla_girl"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <canvas id="imc_girl"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <canvas id="encef_girl"></canvas>
                </div>
            </div>
        @endif

        <!-- Modal -->
        <div class="modal fade" id="exampleModalMasa" tabindex="-1" aria-labelledby="exampleModalLabelMEd"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelMEd">Antropometría </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('datos.store', $pac->id) }}" method="POST" class="multiple_form"
                        autocomplete="off">
                        <div class="modal-body">
                            <div class="container">
                                <br />

                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group">
                                        <label for="stockPrice">Edad:</label>
                                        <input type="text" class="form-control" id="edad_act" name="edad_act"
                                            value="{{ $nac }} mes/meses" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="stockPrice">Sexo:</label>
                                        <input type="text" class="form-control" id="genero" name="genero"
                                            value="{{ $pac->genero }} " readonly>
                                    </div>
                                    <br>
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <div class="mb-1">
                                            <div class="form-group">
                                                <br />
                                                <label for="stockPrice">Peso(kg):</label>
                                                <input type="text" class="form-control" id="peso" name="peso">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <div class="mb-1">
                                            <div class="form-group">
                                                <br />
                                                <label for="stockPrice">Talla(cm):</label>
                                                <input type="text" class="form-control" id="scoreP" name="estatura"
                                                    oninput="LengthConverter(this.value)"
                                                    onchange="LengthConverter(this.value)" onkeyup="div()">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <div class="mb-1">
                                            <div class="form-group">
                                                <label for="stockPrice">Cálculo IMC(kg/m2):</label>
                                                <input type="text" class="form-control" id="masa" name="masa"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-12">
                                        <div class="mb-1">
                                            <div class="form-group">
                                                <label for="stockPrice">Perímetro Encefálico(cm):</label>
                                                <input type="text" class="form-control" id="peri_encef"
                                                    name="peri_encef">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                </div>

                </form>
            </div>
        </div>

    </section>
    <p type="text" class="form-control" id="outputMeters" name="outputMeters" readonly></p>

@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8">
</script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">

{{-- BOY  --}}
<script>
    const url2 = window.location.pathname;
    const strs = url2.split('/');
    const id = strs.at(-1);
    var urlP = `{{ url('datos/chart/${id}') }}`;
    var Nac = new Array();
    var Labels = new Array();
    var Prices = new Array();
    $(document).ready(function() {
        $.get(urlP, function(response) {
            response.forEach(function(data) {
                Nac.push(data.edad_act);Labels.push(data.user_id);
                Prices.push(data.peso);
            });
            var ctx = document.getElementById("PesoEdad");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: 
                    //Nac,
                     ["Nac.", "2", "4", "6", "8", "10", "1 Año", "2", "4", "6", "8", "10",
                            "2 Años","2", "4","6", "8", "10", "3 Años", "2", "4", "6", "8", "10", "4 Años", "2",
                            "4", "6", "8", "10", "5 Años"
                        ],  
                        // [Nac, ""], 
                    datasets: [{
                            label: 'Curva de Crecimiento(Peso)',
                            data: Prices,
                            borderWidth: 3,
                            borderColor: 'rgb(75, 192, 192)',
                            fill: false,
                            pointRadius: 5,
                            pointBorderColor: 'rgb(0, 0, 0)'
                        },
                        /* {
                            label: ScoreP,
                            data: ScoreP,
                            borderColor: "rgba(255, 99, 71)",
                            backgroundColor: "rgba(255, 99, 71)",
                        } */
                        {
                            data: [2.1, 3.8, 4.9, 5.7, 6.2, 6.6, 6.9, 7.2, 7.5, 7.8, 8.1, 8.4,
                                8.6, 8.9, 9.1, 9.4, 9.6, 9.8, 10, 10.2, 10.4, 10.6, 10.8, 11, 11.2,
                                11.4, 11.6, 11.8, 12, 12.2, 12.4
                            ],
                            borderColor: "grey",
                            fill: false
                        }, {
                            data: [4.4, 7.1, 8.7, 9.8, 10.7, 11.4, 12, 12.6, 13.1, 13.7, 14.2,
                                14.7, 15.3,
                                15.8, 16.3, 16.9, 17.4, 17.8, 18.3, 18.8, 19.3, 19.7, 20.2,
                                20.7, 21.2,
                                21.7, 22.2, 22.7, 23.2, 23.7, 24.2
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [3.3, 5.6, 7, 7.9, 8.6, 9.2, 9.6, 10.1, 10.5, 10.9, 11.3,
                                11.8, 12.2,
                                12.5, 12.9, 13.3, 13.7, 14, 14.3, 14.7, 15, 15.3, 15.7, 16,
                                16.3, 16.7,
                                17, 17.3, 17.7, 18, 18.3
                            ],
                            borderColor: "green",
                            fill: false
                        }, {
                            data: [2.5, 4.3, 5.6, 6.4, 6.9, 7.4, 7.7, 8.1, 8.4, 8.8, 9.1, 9.4,
                                9.7, 10,
                                10.2, 10.5, 10.8, 11, 11.3, 11.5, 11.8, 12, 12.2, 12.5,
                                12.7, 12.9,
                                13.2, 13.4, 13.6, 13.8, 14.1
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [5, 8, 9.7, 10.9, 11.9, 12.7, 13.3, 14, 14.6, 15.3, 15.9,
                                16.5, 17.1,
                                17.8, 18.4, 19, 19.6, 20.2, 20.7, 21.3, 21.9, 22.4, 23,
                                23.6, 24.2,
                                24.8, 25.4, 26, 26.6, 27.2, 27.9
                            ],
                            borderColor: "grey",
                            fill: false
                        },
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Curva de Crecimiento (Peso-Edad)'
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Peso (Kg)'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Edad (Meses y años cumplidos)'
                            }
                        }]
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    }
                }
            });
        });
    });

    
    var url = `{{ url('datos/chart/${id}') }}`;
    //console.log(url);
    var YearsT = new Array();
    var LabelsT = new Array();
    var Est = new Array();
    var ScoreA = new Array();
    $(document).ready(function() {
        $.get(url, function(response) {
            response.forEach(function(data) {
                YearsT.push(data.edad_act);
                LabelsT.push(data.user_id);
                Est.push(data.estatura);
                ScoreA.push(data.scoreA);
            });
            var ctx = document.getElementById("TallaEdad");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: 
                    //YearsT,
                    //[YearsT, ""], 
                        ["Nac.", "2", "4", "6", "8", "10", "1 Año", "2", "4", "6", "8", "10",
                            "2 Años","2", "4","6", "8", "10", "3 Años", "2", "4", "6", "8", "10", "4 Años", "2",
                            "4", "6", "8", "10", "5 Años"
                        ], 
                    datasets: [{
                            label: 'Curva de Crecimiento (Talla)',
                            data: Est,
                            borderWidth: 3,
                            borderColor: 'rgb(75, 192, 192)',
                            fill: false,
                            pointRadius: 5,
                            pointBorderColor: 'rgb(0, 0, 0)'
                        },
                        /* {
                            label: ScoreA,
                            data: ScoreA,
                            borderColor: "rgba(255, 99, 71)",
                            backgroundColor: "rgba(255, 99, 71)",
                        } */
                        {
                            data: [44.2, 52.4, 57.6, 61.2, 64, 66.4, 68.6, 70.6, 72.5, 74.2,
                                75.8, 77.2,
                                78, 79.3, 80.5, 81.7, 82.8, 83.9, 85, 86, 87, 88, 88.9,
                                89.8, 90.7,
                                91.6, 92.5, 93.4, 94.3, 95.2, 96.1
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [46.1, 54.4, 59.7, 63.3, 66.2, 68.7, 71, 73.1, 75, 76.9,
                                78.6, 80.2,
                                81, 82.5, 83.8, 85.1, 86.4, 87.5, 88.7, 89.8, 90.9,
                                91.9, 93, 94,
                                94.9, 95.9, 96.9, 97.8, 98.8, 99.7, 100.7
                            ],
                            borderColor: "orange",
                            fill: false
                        }, {
                            data: [49.9, 58.4, 63.9, 67.6, 70.6, 73.3, 75.7, 78, 80.2, 82.3,
                                84.2, 86,
                                87.1, 88.8, 90.4, 91.9, 93.4, 94.8, 96.1, 97.4, 98.6,
                                99.9, 101,
                                102.2, 103.3, 104.4, 105.6, 106.7, 107.8, 108.9, 110
                            ],
                            borderColor: "green",
                            fill: false
                        }, {
                            data: [53.7, 62.4, 68, 71.9, 75, 77.9, 80.5, 83, 85.4, 87.7,
                                89.8, 91.9,
                                93.2, 95.2, 97, 98.7, 100.4, 102, 103.5, 105, 106.4,
                                107.8, 109.1,
                                110.4, 111.7, 113, 114.2, 115.5, 116.7, 118, 119.2
                            ],
                            borderColor: "orange",
                            fill: false
                        }, {
                            data: [55.6, 64.4, 70.1, 74, 77.2, 80.1, 82.9, 85.5, 88, 90.4,
                                92.6, 94.9,
                                96.3, 98.3, 100.3, 102.1, 103.9, 105.6, 107.2, 108.8,
                                110.3, 111.7,
                                113.2, 114.6, 115.9, 117.3, 118.6, 119.9, 121.2, 122.6,
                                123.6
                            ],
                            borderColor: "red",
                            fill: false
                        },
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Curva de Crecimiento (Talla-Edad)'
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Talla (cm)'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Edad (Meses y años cumplidos)'
                            }
                        }]
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    }
                }
            });
        });
    });
    var urlM = `{{ url('datos/chart/${id}') }}`;
    //console.log(urlM);
    var YearsM = new Array();
    var LabelsM = new Array();
    var Masa = new Array();
    var ScoreImc = new Array();
    $(document).ready(function() {
        $.get(urlM, function(response) {
            response.forEach(function(data) {
                YearsM.push(data.edad_act);
                LabelsM.push(data.user_id);
                Masa.push(data.masa);
                ScoreImc.push(data.scoreImc);
            });
            var ctx = document.getElementById("imc_edad");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: 
                    //YearsM,
                    //[YearsM, ""], 
                         ["Nac.", "2", "4", "6", "8", "10", "1 Año", "2", "4", "6", "8", "10",
                            "2 Años","2", "4", "6", "8", "10", "3 Años", "2", "4", "6", "8", "10", "4 Años", "2",
                            "4", "6", "8", "10", "5 Años"
                        ], 
                    datasets: [{
                            label: 'Curva de Crecimiento(IMC)',
                            data: Masa,
                            borderWidth: 3,
                            borderColor: 'rgb(75, 192, 192)',
                            fill: false,
                            pointRadius: 5,
                            pointBorderColor: 'rgb(0, 0, 0)'
                        },
                        /* {
                            label: ScoreImc,
                            data: ScoreImc,
                            borderColor: "rgba(255, 99, 71)",
                            backgroundColor: "rgba(255, 99, 71)",
                        } */
                        {
                            data: [10.2, 12.5, 13.4, 13.6, 13.6, 13.5, 13.4, 13.2, 13.1,
                                12.9, 12.8, 12.7, 12.9, 12.8, 12.7, 12.6, 12.5, 12.5, 12.4, 12.3,
                                12.3, 12.2, 12.2, 12.1, 12.1, 12.1, 12, 12, 12, 12, 12
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [11.1, 13.7, 14.5, 14.7, 14.7, 14.6, 14.4, 14.2, 14, 13.9,
                                13.7, 13.6,
                                13.8, 13.7, 13.6, 13.6, 13.5, 13.4, 13.4, 13.3, 13.2,
                                13.2, 13.1,
                                13.1, 13.1, 13, 13, 13, 12.9, 12.9, 12.9
                            ],
                            borderColor: "orange",
                            fill: false
                        }, {
                            data: [13.4, 16.3, 17.2, 17.3, 17.3, 17, 16.8, 16.6, 16.3, 16.1,
                                16, 15.8,
                                16, 15.9, 15.9, 15.8, 15.7, 15.7, 15.6, 15.5, 15.5,
                                15.4, 15.4,
                                15.4, 15.3, 15.3, 15.3, 15.3, 15.2, 15.2, 15.2
                            ],
                            borderColor: "green",
                            fill: false
                        }, {
                            data: [16.3, 19.4, 20.3, 20.5, 20.4, 20.1, 19.8, 19.5, 19.3, 19,
                                18.8, 18.7,
                                18.6, 18.9, 18.8, 18.7, 18.6, 18.5, 18.4, 18.4, 18.3,
                                18.2, 18.2,
                                18.2, 18.2, 18.2, 18.2, 18.2, 18.2, 18.2, 18.3, 18.3
                            ],
                            borderColor: "orange",
                            fill: false
                        }, {
                            data: [18.1, 21.1, 22.1, 22.3, 22.2, 22, 21.6, 21.3, 21, 20.8,
                                20.6, 20.4,
                                20.3, 20.6, 20.5, 20.4, 20.2, 20.1, 20, 20, 19.9, 19.9,
                                19.8, 19.8,
                                19.8, 19.9, 19.9, 19.9, 20, 20.1, 20.2, 20.3, 20.3
                            ],
                            borderColor: "red",
                            fill: false
                        },
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Curva de Crecimiento (IMC-Edad)'
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'IMC (kg/m2)'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Edad (Meses y años cumplidos)'
                            }
                        }]
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    }
                }
            });
        });
    });
    var urlPeri = `{{ url('datos/chart/${id}') }}`;
    //console.log(urlPeri);
    var YearsPeri = new Array();
    var LabelsP = new Array();
    var Peri = new Array();
    var ScorePeri = new Array();
    $(document).ready(function() {
        $.get(urlPeri, function(response) {
            response.forEach(function(data) {
                YearsPeri.push(data.edad_act);
                LabelsP.push(data.user_id);
                Peri.push(data.peri_encef);
                ScorePeri.push(data.scorePeri);
            });
            var ctx = document.getElementById("perim_edad");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels:
                    //YearsPeri,
                    //[YearsPeri, " "], 
                         ["Nac.", "2", "4", "6", "8", "10", "1 Año", "2", "4", "6", "8", "10",
                            "2 Años", "2", "4", "6", "8", "10", "3 Años", "2", "4", "6", "8",
                            "10", "4 Años", "2", "4", "6", "8", "10", "5 Años"
                        ],
                    datasets: [{
                            label: 'Curva de Crecimiento Perímetro Cefálico',
                            data: Peri,
                            borderWidth: 3,
                            borderColor: 'rgb(75, 192, 192)',
                            fill: false,
                            pointRadius: 5,
                            pointBorderColor: 'rgb(0, 0, 0)'
                            //backgroundColor: "#87ceeb61"
                        },
                        /* {
                            label: ScorePeri,
                            data: ScorePeri,
                            borderColor: "rgba(255, 99, 71)",
                            backgroundColor: "rgba(255, 99, 71)",
                        } */
                        {
                            data: [30.7, 35.6, 38, 39.7, 40.8, 41.6, 42.2, 42.7, 43.1, 43.4,
                                43.7, 43.9,
                                44.2, 44.4, 44.6, 44.8, 44.9, 45.1, 45.2, 45.3, 45.4,
                                45.5, 45.6,
                                45.7, 45.8, 45.9, 46, 46.1, 46.1, 46.2, 46.3
                            ],
                            borderColor: "grey",
                            fill: false
                        }, {
                            data: [31.9, 36.8, 39.2, 40.9, 42, 42.9, 43.5, 44, 44.4, 44.7,
                                45, 45.3,
                                45.5, 45.8, 46, 46.1, 46.3, 46.5, 46.6, 46.8, 46.9, 47,
                                47.1, 47.2,
                                47.3, 47.4, 47.5, 47.5, 47.6, 47.7, 47.7
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [34.5, 39.1, 41.6, 43.3, 44.5, 45.4, 46.1, 46.6, 47, 47.4,
                                47.7, 48,
                                48.3, 48.5, 48.7, 48.9, 49.1, 49.3, 49.5, 49.6, 49.7,
                                49.9, 50,
                                50.1, 50.2, 50.3, 50.4, 50.5, 50.6, 50.7, 50.7
                            ],
                            borderColor: "green",
                            fill: false
                        }, {
                            data: [37, 41.5, 44, 45.8, 47, 47.9, 48.6, 49.2, 49.6, 50, 50.4,
                                50.7, 51,
                                51.2, 51.5, 51.7, 51.9, 52.1, 52.3, 52.5, 52.6, 52.8,
                                52.9, 53,
                                53.1, 53.2, 53.4, 53.5, 53.5, 53.6, 53.7
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [38.3, 42.6, 45.2, 47, 48.3, 49.2, 49.9, 50.5, 51, 51.4,
                                51.7, 52,
                                52.3, 52.6, 52.9, 53.1, 53.3, 53.5, 53.7, 53.9, 54.1,
                                54.2, 54.3,
                                54.5, 54.6, 54.7, 54.8, 54.9, 55, 55.1, 55.2
                            ],
                            borderColor: "grey",
                            fill: false
                        },
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Curva de Crecimiento (Perímetro Encefálico-Edad)'
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Perímetro Encefálico (cm)'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Edad (Meses y años cumplidos)'
                            }
                        }]
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    }
                }
            });
        });
    });
</script>



{{-- GIRL   --}}
<script>
    var urlP = `{{ url('datos/chart/${id}') }}`;
    var YearsPe = new Array();
    var LabelsG = new Array();
    var PricesG = new Array();
    var ScoreP = new Array();
    $(document).ready(function() {
        $.get(urlP, function(response) {
            response.forEach(function(data) {
                YearsPe.push(data.edad_act);
                LabelsG.push(data.user_id);
                PricesG.push(data.peso);
                ScoreP.push(data.scoreP);
            });
            var ctx = document.getElementById("peso_girl");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: 
                    //YearsPe,
                        ["Nac.", "2", "4", "6", "8", "10", "1 Año", "2", "4", "6", "8", "10",
                            "2 Años", "2", "4", "6", "8", "10", "3 Años", "2", "4", "6", "8",
                            "10", "4 Años", "2", "4", "6", "8", "10", "5 Años"
                        ], 
                    datasets: [{
                            label: 'Curva de Crecimiento(Peso)',
                            data: PricesG,
                            borderWidth: 3,
                            borderColor: 'rgb(219, 180, 20)',
                            fill: false,
                            pointRadius: 5,
                            pointBorderColor: 'rgb(0, 0, 0)'
                              
                        },
                        /* {
                            label: ScoreP,
                            data: ScoreP,
                            borderColor: "rgba(255, 99, 71)",
                            backgroundColor: "rgba(255, 99, 71)",
                        } */
                        {
                            data: [2, 3.4, 4.4, 5.1, 5.6, 5.9, 6.3, 6.6, 6.9, 7.2, 7.5, 7.8,
                                8.1, 8.4,
                                8.6, 8.9, 9.1, 9.4, 9.6, 9.8, 10.1, 10.3, 10.5, 10.7,
                                10.9, 11.1,
                                11.3, 11.5, 11.7, 11.9, 12.1
                            ],
                            borderColor: "grey",
                            fill: false
                        }, {
                            data: [2.4, 3.9, 5, 5.7, 6.3, 6.7, 7, 7.4, 7.7, 8.1, 8.4, 8.7,
                                9, 9.4, 9.7,
                                10, 10.3, 10.5, 10.8, 11.1, 11.3, 11.6, 11.8, 12.1,
                                12.3, 12.6,
                                12.8, 12.9, 13.2, 13.4, 13.5, 13.7
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [3.2, 5.1, 6.4, 7.3, 7.9, 8.5, 8.9, 9.4, 9.8, 10.2, 10.6,
                                11.1, 11.5,
                                11.9, 12.3, 12.7, 13.1, 13.5, 13.9, 14.2, 14.6, 15,
                                15.3, 15.7,
                                16.1, 16.4, 16.8, 17.2, 17.5, 17.9, 18.2
                            ],
                            borderColor: "green",
                            fill: false
                        }, {
                            data: [4.2, 6.6, 8.2, 9.3, 10.2, 10.9, 11.5, 12.1, 12.6, 13.2,
                                13.7, 14.3,
                                14.8, 15.4, 16, 16.5, 17.1, 17.6, 18.1, 18.7, 19.2,
                                19.8, 20.4,
                                20.9, 21.5, 22.1, 22.6, 23.2, 23.8, 24.4, 24.9
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [4.8, 7.5, 9.3, 10.6, 11.6, 12.4, 13.1, 13.8, 14.5, 15.1,
                                15.7, 16.4,
                                17, 17.7, 18.3, 19, 19.6, 20.3, 20.9, 21.6, 22.3, 23,
                                23.7, 24.5,
                                25.2, 25.9, 26.6, 27.4, 28.1, 28.8, 29.5
                            ],
                            borderColor: "grey",
                            fill: false
                        },
                        
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Curva de Crecimiento (Peso-Edad)'
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Peso (kg)'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Edad (Meses y años cumplidos)'
                            }
                        }]
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    }
                }
            });
        });
    });
    var url = `{{ url('datos/chart/${id}') }}`;
    //console.log(url);
    var YearsTG = new Array();
    var LabelsTG = new Array();
    var EstG = new Array();
    var ScoreAG = new Array();
    $(document).ready(function() {
        $.get(url, function(response) {
            response.forEach(function(data) {
                YearsTG.push(data.edad_act);
                LabelsTG.push(data.user_id);
                EstG.push(data.estatura);
                ScoreAG.push(data.scoreAG);
            });
            var ctx = document.getElementById("talla_girl");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: 
                    //YearsTG,
                         ["Nac.", "2", "4", "6", "8", "10", "1 Año", "2", "4", "6", "8", "10",
                            "2 Años", "2", "4", "6", "8", "10", "3 Años", "2", "4", "6", "8", "10", "4 Años", "2",
                            "4", "6", "8", "10", "5 Años"
                        ], 
                    datasets: [{
                            label: 'Curva de Crecimiento (Talla)',
                            data: EstG,
                            borderWidth: 3,
                            borderColor: 'rgb(219, 180, 20)',
                            fill: false,
                            pointRadius: 5,
                            pointBorderColor: 'rgb(0, 0, 0)'
                        },
                        /* {
                            label: ScoreA,
                            data: ScoreA,
                            borderColor: "rgba(255, 99, 71)",
                            backgroundColor: "rgba(255, 99, 71)",
                        } */
                        {
                            data: [43.6, 51., 55.6, 58.9, 61.7, 64.1, 66.3, 68.3, 70.2, 72,
                                73.7, 75.2,
                                76, 77.5, 78.8, 80.1, 81.3, 82.5, 83.6, 84.7, 85.8,
                                86.8, 87.9,
                                88.9, 89.8, 90.7, 91.7, 92.6, 93.4, 94.3, 95.2
                            ],
                            borderColor: "grey",
                            fill: false
                        }, {
                            data: [45.4, 53, 57.8, 61.2, 64, 66.5, 68.9, 71, 73, 74.9, 76.7,
                                78.4, 79.3,
                                80.8, 82.2, 83.6, 84.9, 86.2, 87.4, 88.6, 89.8, 90.9,
                                92, 93.1,
                                94.1, 95.1, 96.1, 97.1, 98.1, 99, 99.9
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [49.1, 57.1, 62.1, 65.7, 68.7, 71.5, 74, 76.4, 78.6, 80.7,
                                82.7, 84.6,
                                85.7, 87.4, 89.1, 90.7, 92.2, 93.6, 95.1, 96.4, 97.7,
                                99, 100.3,
                                101.5, 102.7, 103.9, 105, 106.2, 107.3, 108.4, 109.4
                            ],
                            borderColor: "green",
                            fill: false
                        }, {
                            data: [52.9, 61.1, 66.4, 70.3, 73.5, 76.4, 79.2, 81.7, 84.2,
                                86.5, 88.7,
                                90.8, 92.2, 94.1, 96, 97.7, 99.4, 101.1, 102.7, 104.2,
                                105.7, 107.2,
                                108.6, 110, 111.3, 112.7, 114, 115.2, 116.5, 117.7,
                                118.9
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [54.7, 63.2, 68.6, 72.5, 75.8, 78.9, 81.7, 84.4, 87, 89.4,
                                91.7, 94,
                                95.4, 97.4, 99.4, 101.3, 103.1, 104.8, 106.5, 108.1,
                                109.7, 111.2,
                                112.7, 114.2, 115.7, 117.1, 118.4, 119.8, 121.1, 122.4,
                                123.7
                            ],
                            borderColor: "grey",
                            fill: false
                        },
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Curva de Crecimiento (Talla-Edad)'
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Talla (cm)'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Edad (Meses y años cumplidos)'
                            }
                        }]
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    }
                }
            });
        });
    });
    var urlM = `{{ url('datos/chart/${id}') }}`;
    //console.log(urlM);
    var YearsMG = new Array();
    var LabelsMG = new Array();
    var MasaG = new Array();
    var ScoreImcG = new Array();
    $(document).ready(function() {
        $.get(urlM, function(response) {
            response.forEach(function(data) {
                YearsMG.push(data.edad_act);
                LabelsMG.push(data.user_id);
                MasaG.push(data.masa);
                ScoreImcG.push(data.scoreImc);
            });
            var ctx = document.getElementById("imc_girl");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: 
                    //YearsM,
                        ["Nac.", "2", "4", "6", "8", "10", "1 Año", "2", "4", "6", "8", "10",
                            "2 Años", "2", "4", "6", "8", "10", "3 Años", "2", "4", "6", "8",
                            "10",
                            "4 Años", "2", "4", "6", "8", "10", "5 Años"
                        ], 
                    datasets: [{
                            label: 'Curva de Crecimiento(IMC)',
                            data: MasaG,
                            borderWidth: 3,
                            borderColor: 'rgb(219, 180, 20)',
                            fill: false,
                            pointRadius: 5,
                            pointBorderColor: 'rgb(0, 0, 0)'
                        },
                        /* {
                            label: ScoreImc,
                            data: ScoreImc,
                            borderColor: "rgba(255, 99, 71)",
                            backgroundColor: "rgba(255, 99, 71)",
                        } */
                        {
                            data: [10.1, 11.8, 12.7, 13, 13, 12.9, 12.7, 12.6, 12.4, 12.3,
                                12.2, 12.2,
                                12.4, 12.3, 12.3, 12.3, 12.2, 12.2, 12.1, 12.1, 12, 12,
                                11.9, 11.9,
                                11.8, 11.8, 11.7, 11.7, 11.7, 11.7, 11.6
                            ],
                            borderColor: "grey",
                            fill: false
                        }, {
                            data: [11.1, 13, 13.9, 14.1, 14.1, 14, 13.8, 13.6, 13.5, 13.3,
                                13.2, 13.1,
                                13.3, 13.3, 13.3, 13.3, 13.2, 13.2, 13.1, 13.1, 13, 13,
                                12.9, 12.9,
                                12.9, 12.8, 12.8, 12.8, 12.7, 12.7, 12.7, 12.7
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [13.3, 15.8, 16.7, 16.9, 16.8, 16.6, 16.4, 16.1, 15.9,
                                15.7, 15.6,
                                15.5, 15.7, 15.6, 15.6, 15.5, 15.5, 15.4, 15.4, 15.4,
                                15.3, 15.3,
                                15.3, 15.3, 15.3, 15.3, 15.2, 15.3, 15.3, 15.3, 15.3
                            ],
                            borderColor: "green",
                            fill: false
                        }, {
                            data: [16.1, 19, 20, 20.3, 20.2, 19.9, 19.6, 19.3, 19.1, 18.8,
                                18.7, 18.5,
                                18.7, 18.7, 18.6, 18.5, 18.5, 18.5, 18.4, 18.4, 18.4,
                                18.4, 18.5,
                                18.5, 18.5, 18.6, 18.6, 18.7, 18.7, 18.8, 18.8
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [17.7, 20.7, 22, 22.3, 22.2, 21.9, 21.6, 21.3, 21, 20.8,
                                20.6, 20.4,
                                20.6, 20.6, 20.5, 20.4, 20.4, 20.3, 20.3, 20.3, 20.3,
                                20.4, 20.4,
                                20.5, 20.6, 20.7, 20.7, 20.8, 20.9, 21, 21.1
                            ],
                            borderColor: "grey",
                            fill: false
                        },
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Curva de Crecimiento (IMC-Edad)'
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'IMC (kg/m2)'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Edad (Meses y años cumplidos)'
                            }
                        }]
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    }
                }
            });
        });
    });
    var urlPeri = `{{ url('datos/chart/${id}') }}`;
    //console.log(urlPeri);
    var YearsPeriG = new Array();
    var LabelsPG = new Array();
    var PeriG = new Array();
    var ScorePeriG = new Array();
    $(document).ready(function() {
        $.get(urlPeri, function(response) {
            response.forEach(function(data) {
                YearsPeriG.push(data.edad_act);
                LabelsPG.push(data.user_id);
                PeriG.push(data.peri_encef);
                ScorePeriG.push(data.scorePeri);
            });
            var ctx = document.getElementById("encef_girl");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: 
                    //YearsPeriG,
                         ["Nac.", "2", "4", "6", "8", "10", "1 Año", "2", "4", "6", "8", "10",
                            "2 Años", "2", "4", "6", "8", "10", "3 Años", "2", "4", "6", "8",
                            "10", "4 Años", "2", "4", "6", "8", "10", "5 Años"
                        ], 
                    datasets: [{
                            label: 'Curva de Crecimiento Perímetro Cefálico',
                            data: PeriG,
                            borderWidth: 3,
                            borderColor: 'rgb(219, 180, 20)',
                            fill: false,
                            pointRadius: 5,
                            pointBorderColor: 'rgb(0, 0, 0)'
                        },
                        /* {
                            label: ScorePeri,
                            data: ScorePeri,
                            borderColor: "rgba(255, 99, 71)",
                            backgroundColor: "rgba(255, 99, 71)",
                        } */
                        {
                            data: [30.3, 34.6, 36.8, 38.3, 39.4, 40.2, 40.8, 41.3, 41.7,
                                42.1, 42.4,
                                42.7, 43, 43.3, 43.5, 43.7, 43.9, 44.1, 44.3, 44.4,
                                44.6, 44.7,
                                44.8, 45, 45.1, 45.2, 45.3, 45.4, 45.5, 45.6, 45.7
                            ],
                            borderColor: "grey",
                            fill: false
                        }, {
                            data: [31.5, 35.8, 38.1, 39.6, 40.7, 41.5, 42.2, 42.7, 43.1,
                                43.5, 43.8,
                                44.1, 44.4, 44.7, 44.9, 45.1, 45.3, 45.5, 45.7, 45.8,
                                46, 46.1,
                                46.3, 46.4, 46.5, 46.6, 46.7, 46.8, 46.9, 47, 47.1
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [33.9, 38.3, 40.6, 42.2, 43.4, 44.2, 44.9, 45.4, 45.9,
                                46.2, 46.6,
                                46.9, 47.2, 47.5, 47.7, 47.9, 48.1, 48.3, 48.5, 48.7,
                                48.8, 49,
                                49.1, 49.2, 49.3, 49.4, 49.5, 49.6, 49.7, 49.8, 49.9
                            ],
                            borderColor: "green",
                            fill: false
                        }, {
                            data: [36.2, 40.7, 43.1, 44.8, 46, 46.9, 47.6, 48.2, 48.6, 49,
                                49.4, 49.7,
                                50, 50.3, 50.5, 50.7, 51, 51.2, 51.3, 51.5, 51.7, 51.8,
                                51.9, 52.1,
                                52.2, 52.3, 52.4, 52.4, 52.6, 52.7, 52.8
                            ],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [37.4, 41.9, 44.4, 46.1, 47.4, 48.3, 49, 49.5, 50, 50.4,
                                50.7, 51.1,
                                51.4, 51.7, 51.9, 52.2, 52.4, 52.6, 52.7, 52.9, 53.1,
                                53.2, 53.3,
                                53.5, 53.6, 53.7, 53.8, 53.9, 54, 54.1, 54.2
                            ],
                            borderColor: "grey",
                            fill: false
                        },
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Curva de Crecimiento (Perímetro Encefálico-Edad)'
                    },
                    scales: {
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Perímetro Encefálico(cm)'
                            }
                        }],
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Edad (Meses y años cumplidos)'
                            }
                        }]
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    }
                }
            });
        });
    });
</script>


<script>
    function sumar() {
        const $total = document.getElementById('total');
        let subtotal = 0;
        [...document.getElementsByClassName("monto")].forEach(function(element) {
            if (element.value !== '') {
                subtotal += parseFloat(element.value);
            }
        });
        $total.value = subtotal;
    }
</script>

<script>
    function div() {
        peso = document.getElementById("peso").value;
        alturacudardo = document.getElementById("outputMeters").value;
        var total = document.getElementById("masa").value = parseFloat(peso) / parseFloat(alturacudardo);
        var total = document.getElementById("masa").value = total.toFixed(2);
        console.log(total);
    }
</script>

<script>
    function LengthConverter(valNum) {
        document.getElementById("outputMeters").value = Math.pow(valNum / 100, 2);
    }
</script>
