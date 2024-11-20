<div class="mt-3" id="dicePage">
    <div class="content-box">
        <button class="btn btn-primary w-100" onclick="rollDice();">Rol een dobbelsteen</button>
        <div class="dice-arena mt-3 d-flex flex-column justify-content-center">
            <h1 class="m-0 text-center" id="dice">Gooi een dobbelsteen</h1>
        </div>
    </div>
</div>

<script>
    function rollDice() {
        let dice = document.getElementById('dice');
        dice.innerHTML = getRandomDice();
    }

    function getRandomDice() {
        let dice = {
            1: '<i class="fas fa-dice-one rollDice"></i>',
            2: '<i class="fas fa-dice-two rollDice"></i>',
            3: '<i class="fas fa-dice-three rollDice"></i>',
            4: '<i class="fas fa-dice-four rollDice"></i>',
            5: '<i class="fas fa-dice-five rollDice"></i>',
            6: '<i class="fas fa-dice-six rollDice"></i>',
        };

        let random = Math.floor(Math.random() * 6) + 1;

        return dice[random];
    }
</script>
