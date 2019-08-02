<template>
    <section>

        <b-collapse :open="false" class="card" :aria-id="contentId">
            <div
                slot="trigger" 
                slot-scope="props"
                class="card-header"
                role="button"
                :aria-controls="contentId">
                <p class="card-header-title">
                    {{nombre}}
                </p>
                <a class="card-header-icon">
                    <b-icon
                        :icon="props.open ? 'menu-down' : 'menu-up'">
                    </b-icon>
                </a>
            </div>
            <div class="card-content">
                <div class="content">
                    <div class="tile is-vertical">
                <div class="tile">
                    <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                            <p class="title">FE3 - Primer contacto</p>
                            <a :href="base_url + '/usuario/' + fdg_id" class="button is-info is-fullwidth is-medium">FDG - Ficha de datos generales</a>
                            <div><br></div>
                            <a :href="base_url + '/usuario/' + patient_id + '/cdr'" class="button is-info is-fullwidth is-medium">CDR - Cuestionario de detección de riesgos</a>
                        </article>
                    </div>
                    <div class="tile is-parent">
                        <article class="tile is-child notification">
                            <p class="title">Programa</p>
                            <p class="subtitle">{{programa}}</p>
                        </article>
                    </div>
                </div>
                <div class="tile">
                    <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                            <p class="title">FE4 - Admisión</p>
                            <a :href="base_url + '/usuario/' + patient_id + '/ps'" class="button is-info is-fullwidth is-medium">PS - Plan de servicios</a>
                        </article>
                    </div>
                    <div class="tile is-parent">
                        <article class="tile is-child notification">
                            <p class="title">Programa</p>
                            <p class="subtitle">{{programa}}</p>
                        </article>
                    </div>
                </div>
                <div class="tile">
                    <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                            <p class="title">FE5 - Evaluación</p>
                            <a :href="base_url + '/usuario/' + patient_id + '/re'" class="button is-info  is-fullwidth is-medium">RE -Resultados de evaluación</a>
                        </article>
                    </div>
                    <div class="tile is-parent">
                        <article class="tile is-child notification">
                            <p class="title">Programa</p>
                            <p class="subtitle">{{programa}}</p>
                        </article>
                    </div>
                </div>
                <div class="tile">
                    <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                            <p class="title">FE6 - Orientación / consejo breve</p>
                            <a :href="base_url + '/usuario/' + patient_id + '/breve'" class="button is-info  is-fullwidth is-medium">RS - Resumen de sesión</a>
                        </article>
                    </div>
                    <div class="tile is-parent">
                        <article class="tile is-child notification">
                            <p class="title">Programa</p>
                            <p class="subtitle">{{programa}}</p>
                        </article>
                    </div>
                </div>
                <div class="tile">
                    <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                            <p class="title">FE7 - Intervención</p>
                            <a :href="base_url + '/usuario/' + patient_id + '/intervencion'" class="button is-info  is-fullwidth is-medium">RS - Resumen de sesión</a>
                        </article>
                    </div>
                    <div class="tile is-parent">
                        <article class="tile is-child notification">
                            <p class="title">Programa</p>
                            <p class="subtitle">{{programa}}</p>
                        </article>
                    </div>
                </div>
                <div class="tile">
                    <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                            <p class="title">FE8 - Egreso</p>
                            <a :href="base_url + '/usuario/' + patient_id + '/he'" class="button is-info  is-fullwidth is-medium">HE - Hoja de egreso</a>
                            <div><br></div>
                            <a :href="base_url + '/usuario/' + patient_id + '/cssp'" class="button is-info  is-fullwidth is-medium">CSSP - Cuestionario de satisfacción</a>
                        </article>
                    </div>
                    <div class="tile is-parent">
                        <article class="tile is-child notification">
                            <p class="title">Programa</p>
                            <p class="subtitle">{{programa}}</p>
                        </article>
                    </div>
                </div>
            </div>
        </div> 
                </div>
            </div>
        </b-collapse>

    </section>
</template>
<script>
export default {
    props:['contentId', 'programa', 'nombre', 'base_url', 'patient_id', 'fdg_id']
}
</script>
