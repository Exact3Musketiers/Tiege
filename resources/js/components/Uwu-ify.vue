<template>
    <div class="row mt-5">
        <div class="card bg-dark col-md-12">
            <div class="card-header">UwUify</div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="text" class="form-label">Je text</label>
                    <textarea class="form-control form-control-lg" id="uwuin" rows="3" placeholder="UwU in" v-model="textToUwuIfy"></textarea>
                </div>
                <label for="text" class="form-label">Je UwU</label>
                <div class="input-group mb-3">
                    <textarea class="form-control form-control-lg" id="uwuout" rows="3"
                        placeholder="UwU out" v-model="textUwuFied"></textarea>
                    <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#uwuModel"><i
                            class="far fa-copy"></i></button>
                </div>
                <!-- <button class="btn btn-primary">UwUify!</button> -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            textToUwuIfy: '',
        };
    },

    computed: {
        textUwuFied: function () {
            let smileyTextArray = ['UWU', 'OWO', '*aaaargg*', '*wdf!*']
            let text = this.textToUwuIfy.replace(/r|l/g, 'w')
                .replace(/L|R/g, 'W')
                .replaceAll('Na', 'Nya')
                .replaceAll('na', 'nya')
                .replaceAll('et', 'ewt')
                .replaceAll('Et', 'Ewt')
                .replaceAll('ne', 'nye')
                .replaceAll('Ne', 'Nye')
                .replaceAll('nu', 'nyu')
                .replaceAll('Nu', 'Nyu')
                .replaceAll('ni', 'nyi')
                .replaceAll('NI', 'Nyi')
                .replaceAll('haha', 'hihi')
                .replaceAll('Haha', 'Hihi ^-^')
                .replaceAll('!', '!!1!')
                .replaceAll('?', '?!')
                .replaceAll('Ik ', 'I-Ik UwU ')
                .replaceAll('ik ', 'i-ik ')
                .replaceAll(' ik ', ' i-ik ')
                .replaceAll(' Ik ', ' I-Ik ')
                .replaceAll('uh ', 'u-uh ')
                .replaceAll(' uh ', ' u-uh ');

            for (var i = 0; i < text.length; i++) {
                if (text.charAt(i) === '.') {
                    text = this.replaceAt(text, i, '. ' + smileyTextArray[Math.floor(Math.random() * smileyTextArray.length)])
                }

                if (text.charAt(i) === ',') {
                    text = this.replaceAt(text, i, ', ' + smileyTextArray[Math.floor(Math.random() * smileyTextArray.length)])
                }
            }

            return text;

        }
    },

    methods: {
        replaceAt(str,index,chr) {
            if(index > str.length-1) return str;
            return str.substring(0,index) + chr + str.substring(index+1);
        },
    },


};
</script>
