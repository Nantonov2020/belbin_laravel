@extends('layouts.user')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <form action="{{route('user.answer')}}" method="POST" onsubmit="return checkInput();">
                    @csrf
                    <input type="hidden" name="number" value="{{$questionares->getNumber()}}">
                <div class="card-header"><b>{{ $questionares->getQuestion() }}</b></div>

                <div class="card-body">

                    <span class="info" style="color:red; font-size: 20px"></span>
                    @foreach ($questionares->getAnswers() as $key=>$item)

                        <div class="form-group row">
                            <label for="secondName" class="col-md-10 col-form-label text-md-right">
                                {{ $item }}
                            </label>

                            <div class="col-md-2">
                                <select name="answers[{{ $key }}]" class="answer">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </div>

                    @endforeach

                    <div class="form-group row">
                        <div class="col-md-12">
                            <p>
                                <input type="submit" class="btn btn-primary btn-lg btn-block" value="Продолжить">
                            </p>
                        </div>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>

@stop

@push('scripts')
    <script>
        let fieldsAnswer = document.querySelectorAll('.answer');

        fieldsAnswer.forEach(function(item) {
            item.addEventListener('change', checkSumElements);
        });

        function checkSumElements()
        {
            deleteInformationAboutError();

            let sum = giveSumElements();
            if (sum > 10) {
                giveError();
            }
        }

        function deleteInformationAboutError()
        {
            let fieldsAnswer = document.querySelectorAll('.answer');
            fieldsAnswer.forEach(function(item) {
                item.style.backgroundColor = '#fff';
            });
            sendMessageError(0);
        }

        function giveSumElements()
        {
            sum = 0;
            let fieldsAnswer = document.querySelectorAll('.answer');
            fieldsAnswer.forEach(function(item) {
                sum += +item.value;
            });
            return sum;
        }

        function giveError(){
            let fieldsAnswer = document.querySelectorAll('.answer');
            fieldsAnswer.forEach(function(item) {
                item.style.backgroundColor = '#FA8072';
            });
            sendMessageError(1);
        }

        /**
         * @param number
         * number: 0 - remove information about error
         * 1 - summ don't equal 10
         */
        function sendMessageError(number)
        {
            if (number == 0) {
                document.querySelector('.info').innerHTML = '';
            }else{
                document.querySelector('.info').innerHTML = 'Сумма всех значений должна равняться десяти.<br>';
            }
        }

        function checkInput()
        {
            let sum = giveSumElements();
            if (sum != 10) {
                giveError();
                return false;
            }
            return true;
        }

    </script>
@endpush
