<?php

include('header.php');

?>
<style>
    body {
        min-height: auto;
    }

    .cont {
        width: 100%;
        height: 91vh;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }

    .cont a {
        transform: translateY(-50px);
    }
</style>
<div class="cont">
    <a href="question.php">
        <button class="btn btn-primary">Start Test</button>
    </a>
</div>
<script src="script.js"></script>
</body>

</html>