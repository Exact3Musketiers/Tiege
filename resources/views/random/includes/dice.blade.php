<div class="row mt-3" id="dicePage">
    <div class="card bg-dark col-md-12">
        <div class="card-body">
            <button class="btn btn-primary w-100" onclick="rollDice();">Rol een dobbelsteen</button>
            <div class="dice-arena mt-3 d-flex flex-column justify-content-center">
                <h1 class="m-0 text-center" id="dice">Gooi een dobbelsteen</h1>
            </div>
        </div>
    </div>
</div>

<script>
    function rollDice() {
        let dice = document.getElementById('dice');
        let number = getRandomDice();
        dice.innerHTML = number;
    }

   function getRandomDice() {
        let dice;
        let random = Math.floor(Math.random() * 6) + 1;
        switch (random) {
            case 1:
                dice = '<i class="fas fa-dice-one rollDice"></i>';
                break;
            case 2:
                dice = '<i class="fas fa-dice-two rollDice"></i>';
                break;
            case 3:
                dice = '<i class="fas fa-dice-three rollDice"></i>';
                break;
            case 4:
                dice = '<i class="fas fa-dice-four rollDice"></i>';
                break;
            case 5:
                dice = '<i class="fas fa-dice-five rollDice"></i>';
                break;
            case 6:
                dice = '<i class="fas fa-dice-six rollDice"></i>';
                break;
        }

        return dice;
   }
</script>
