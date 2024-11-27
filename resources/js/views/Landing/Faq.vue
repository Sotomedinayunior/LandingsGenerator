<template>
    <div class="faq">
        <h1>Preguntas Frecuentes</h1>
        <div v-for="(faq, index) in faqs" :key="index" class="faq-item">
            <h3 @click="toggleFaq(index)">{{ faq.question }}</h3>
            <p v-if="faq.open">{{ faq.answer }}</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            faqs: [
                {
                    question: "¿Cuál es el horario de atención?",
                    answer: "Nuestro horario de atención es de lunes a viernes de 9:00 a 18:00.",
                    open: false
                },
                {
                    question: "¿Cómo puedo contactar con soporte?",
                    answer: "Puedes contactar con soporte a través de nuestro formulario de contacto o llamando al 123-456-7890.",
                    open: false
                },
                {
                    question: "¿Dónde están ubicadas sus oficinas?",
                    answer: "Nuestras oficinas están ubicadas en la calle Falsa 123, Ciudad Ejemplo.",
                    open: false
                }
            ]
        };
    },
    methods: {
        toggleFaq(index) {
            this.faqs[index].open = !this.faqs[index].open;
        }
    }
};
</script>

<style scoped>
.faq {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.faq-item {
    margin-bottom: 20px;
}

.faq-item h3 {
    cursor: pointer;
    color: #007bff;
}

.faq-item p {
    margin-top: 10px;
}
</style>