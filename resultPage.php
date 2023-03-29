<?php

include('header.php');
?>


<style>
    .statusBox {
            width: 150px;
            /* height: 40px; */
            padding: 5px;
            /* background-color: rgb(109, 221, 109); */
            border-radius: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, Helvetica, sans-serif;
        }
    .correct{
            border: 2px solid rgb(109, 221, 109);
            color: rgb(109, 221, 109);
    }
    .incorrect{
            border: 2px solid rgb(247, 99, 99);
            color: rgb(247, 99, 99);
    }
    .result-unattempt{
            border: 2px solid orange;
            color: orange;
    }
    .question
    {
        display: flex;
        align-items: center;
    }
</style>
<div class="container-fluid px-5 ">

    <h3 class="text-center mt-4">Exercise 1: Full Stack Developer Training</h3>
    <hr>
    <div class="d-flex justify-content-center"><b class="d-flex"><span class="text-success">Test Attend</span>
            <div class="time ml-2"></div>
        </b></div>

    <div class="text-center mt-4">
        <button class="btn bg-light px-4 mx-1 border">
            <div class="d-flex align-items-center result">
                <i class="fa-solid fa-square-poll-vertical mr-2 text-primary"></i>

            </div>
            Result
        </button>
        <button class="btn bg-light px-4 mx-1 border">
            <div class="d-flex align-items-center items">
                <i class="fa-solid fa-list mr-2 mr-2 text-primary"></i>

            </div>
            Items
        </button>
        <button class="btn bg-light px-4 mx-1 border">
            <div class="d-flex align-items-center correctcount">
                <i class="fa-solid fa-check mr-2 text-success"></i>

            </div>
            Correct
        </button>
        <button class="btn bg-light px-4 mx-1 border">
            <div class="d-flex align-items-center incorrectcount">
                <i class="fa-solid fa-xmark mr-2 text-danger"></i>
            </div>
            incorrect
        </button>
        <button class="btn bg-light px-4 mx-1 border">
            <div class="d-flex align-items-center unattempt">
                <i class="fa-solid fa-eye-slash mr-2 text-warning"></i>

            </div>
            Unattempted
        </button>
    </div>


    <table class="table table-striped mt-5">
        <thead>
            <tr>
                <th>Sr no</th>
                <th>question</th>
                <th>status</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


    <script src="jquery.js"></script>
    <script>
        var resultdata = JSON.parse(sessionStorage.getItem("resultdata"));
        var storedArray = JSON.parse(sessionStorage.getItem("items"));

        var optionInd = JSON.parse(sessionStorage.getItem("optionInd"));


        let correct = storedArray.filter(function(value) {

            if (value == 1) {
                return value;
            }
        })
        $(".time").html(" On : " + resultdata[2]);
        $(".correctcount").append(correct.length);


        let result = (correct.length * 100) / 11;
        $(".result").append(result.toFixed(2) + "%");

        $(".incorrectcount").append((resultdata[1]) - correct.length);
        $(".items").append(resultdata[0]);
        $(".unattempt").append(resultdata[0] - resultdata[1]);

        $.getJSON('question.json', function(data) {

            var correct_answers = [];
            var correct_index = [];
            for (var i = 0; i < data.length; i++) {
                questionAnswers = JSON.parse(data[i].content_text);


                for (var j = 0; j < questionAnswers.answers.length; j++) {
                    if (questionAnswers.answers[j].is_correct == 1) {
                        correct_answers.push(questionAnswers.answers[j].is_correct);
                        correct_index.push(j);
                    }
                }
            }

            let tabledata = ``;
            for (let i = 0; i < data.length; i++) {
                var questionAnswers = data[i].snippet;
                tabledata += `
                        <tr class="datalist">
                            <td>${i+1}</td>
                            <td class="question" ><a href="reviewPage.php?question_id=${i}" style="text-decoration: none; color:black">${questionAnswers}</a></td>
                            <td class="status">
                                <div class="statusBox">
                                    <i class="fa-solid mr-1 result-icon"></i>
                                </div>
                            </td>
                            <td class="list">`;
                for (let j = 0; j < 4; j++) {
                    if (correct_index[i] == j) {
                        tabledata += `<div class="ans correct">A</div>`;
                    } else {
                        if (optionInd[i] == j) {
                            tabledata += `<div class="ans incorrect">A</div>`;
                        } else {
                            tabledata += `<div class="ans">A</div>`;
                        }
                    }
                }
                tabledata += `</td> </tr>`;
            }

            $('tbody').html(tabledata);
            let status = document.querySelectorAll(".statusBox");
            let resulticon = document.querySelectorAll(".result-icon");

            for (let i = 0; i < data.length; i++) {

                if (correct_answers[i] == storedArray[i]) {
                    status[i].append("correct");
                    status[i].classList.add("correct");
                    resulticon[i].classList.add("fa-check")

                } else if (null == storedArray[i]) {
                    status[i].append("unattempted");
                    status[i].classList.add("result-unattempt");
                    resulticon[i].classList.add("fa-eye-slash")
                } else {
                    status[i].append("incorrect");
                    status[i].classList.add("incorrect");
                    resulticon[i].classList.add("fa-xmark")
                }
            }
        })
    </script>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>



</body>

</html>