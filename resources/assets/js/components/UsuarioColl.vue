<template>
    <section>
        <b-collapse :open="false" class="card" :aria-id="contentId">
            <div
                slot="trigger" 
                slot-scope="props"
                class="card-header"
                role="button"
                :aria-controls="contentId">
                <p class="card-header-title">{{nombre}}</p>
                <a class="card-header-icon">
                    <fai :icon="props.open ? 'angle-down' : 'angle-up'" />
                </a>
            </div>
            <div class="card-content">
                <div class="content">
                    <div class="tile is-vertical">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </b-collapse>
    </section>
</template>
<script>
export default {
    props:['contentId', 'nombre']//, 'asignado', 'nombre', 'base_url', 'patient_id', 'fdg_id']
}
</script>
