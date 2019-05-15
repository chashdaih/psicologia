<template>
    <form @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" >
        <p class="title is-6">Identificación de la persona que requiere el servicio</p>
        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label">Nombre completo</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control is-expanded">
                        <input type="text" class="input" placeholder="Nombre(s)" v-model="form.name" required>
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                </div>
                <div class="field">
                    <p class="control is-expanded">
                        <input type="text" class="input" placeholder="Apellido Paterno" v-model="form.last_name" required>
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('last_name')" v-text="form.errors.get('last_name')"></span>
                </div>
                <div class="field">
                    <p class="control is-expanded">
                        <input type="text" class="input" placeholder="Apellido Materno" v-model="form.mothers_name" required>
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('mothers_name')" v-text="form.errors.get('mothers_name')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Género</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <div class="select is-info">
                            <select v-model="form.gender" required>
                                <option value="0">Mujer</option>
                                <option value="1">Hombre</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Fecha de nacimiento</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input type="date" class="date" v-model="form.birthdate" @change="checkIfOver18" required>
                    </div>
                    <span class="help is-danger" v-if="form.errors.has('birthdate')" v-text="form.errors.get('birthdate')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Estado civil</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <div class="select is-info">
                            <select v-model="form.marital_status" required>
                                <option value="0">Soltero</option>
                                <option value="1">Casado</option>
                                <option value="2">Unión libre</option>
                                <option value="3">Viudo</option>
                                <option value="4">Separado</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">CURP/No.Cuenta/No.Trabajador</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="CURP/No.Cuenta/No.Trabajador" v-model="form.curp" required>
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('curp')" v-text="form.errors.get('curp')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">¿Pertenece a la comunidad UNAM?</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input type="checkbox" v-model="form.is_unam">
                    </div>
                </div>
            </div>
        </div>
        <!-- Pertenece a la comunidad unam -->
        <div v-if="form.is_unam">
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Entidad académica de procedencia</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input type="text" class="input" placeholder="Entidad académica de procedencia" v-model="form.academic_entity" required>
                        </p>
                        <span class="help is-danger" v-if="form.errors.has('academic_entity')" v-text="form.errors.get('academic_entity')"></span>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Eres:</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <div class="select is-info">
                                <select v-model="form.position" required>
                                    <option value="0">Estudiante</option>
                                    <option value="1">Académico</option>
                                    <option value="2">Administrativo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Carrera que estudias</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input type="text" class="input" placeholder="Carrera que estudias" v-model="form.career">
                        </p>
                        <span class="help is-danger" v-if="form.errors.has('career')" v-text="form.errors.get('career')"></span>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Semestre que cursas</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input type="text" class="input" placeholder="Semestre que cursas" v-model="form.semester">
                        </p>
                        <span class="help is-danger" v-if="form.errors.has('semester')" v-text="form.errors.get('semester')"></span>
                    </div>
                </div>
            </div>
        </div>
        <label-select v-model="form.person_requesting" :items="['La persona', 'Padres o tutores', 'Otro familiar', 'Otro']">
            Persona que solicita el servicio            
        </label-select>
        <div class="field is-horizontal" v-if="form.person_requesting">
            <div class="field-label">
                <label class="label">Nombre de quien solicita el servicio</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Nombre de quien solicita el servicio" v-model="form.name_requester">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('name_requester')" v-text="form.errors.get('name_requester')"></span>
                </div>
            </div>
        </div>

        <!-- Tutors -->
        <div v-if="is_under_18">
            <p class="title is-6">La atención es para un menor de edad, anote los datos de los padres o tutores</p>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Nombre del padre, madre o tutor</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input type="text" class="input" placeholder="Nombre del padre, madre o tutor" v-model="form.tutor_name_1">
                        </p>
                        <span class="help is-danger" v-if="form.errors.has('tutor_name_1')" v-text="form.errors.get('tutor_name_1')"></span>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Parentesco</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <div class="select is-info">
                                <select v-model="form.relationship_1">
                                    <option value="0">Madre</option>
                                    <option value="1">Padre</option>
                                    <option value="2">Tutor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Fecha de nacimiento</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input type="date" class="date" v-model="form.tutor_birthdate_1">
                        </div>
                        <span class="help is-danger" v-if="form.errors.has('tutor_birthdate_1')" v-text="form.errors.get('tutor_birthdate_1')"></span>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Nivel máximo de estudios</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <div class="select is-info">
                                <select v-model="form.studies_level_1">
                                    <option value="0">No cuenta con escolaridad</option>
                                    <option value="1">Preescolar</option>
                                    <option value="2">Primaria</option>
                                    <option value="3">Secundaria</option>
                                    <option value="4">Preparatoria</option>
                                    <option value="5">Licenciatura</option>
                                    <option value="6">Posgrado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Ocupación</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input type="text" class="input" placeholder="Ocupación del padre, madre o tutor" v-model="form.occupation_1">
                        </p>
                        <span class="help is-danger" v-if="form.errors.has('occupation_1')" v-text="form.errors.get('occupation_1')"></span>
                    </div>
                </div>
            </div>
            <div class="field" >
                <div class="control">
                    <button v-if="second_tutor === false" class="button is-centered is-warning" @click.prevent="showSecondTutor">
                        Añadir madre, padre o tutor
                    </button>
                </div>
            </div>
        </div>
        
        <div v-if="second_tutor">
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Nombre del padre, madre o tutor</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input type="text" class="input" placeholder="Nombre del padre, madre o tutor" v-model="form.tutor_name_21">
                        </p>
                        <span class="help is-danger" v-if="form.errors.has('tutor_name_2')" v-text="form.errors.get('tutor_name_2')"></span>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Parentesco</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <div class="select is-info">
                                <select v-model="form.relationship_2">
                                    <option value="0">Madre</option>
                                    <option value="1">Padre</option>
                                    <option value="2">Tutor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Fecha de nacimiento</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input type="date" class="date" v-model="form.tutor_birthdate_2">
                        </div>
                        <span class="help is-danger" v-if="form.errors.has('tutor_birthdate_2')" v-text="form.errors.get('tutor_birthdate_2')"></span>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Nivel máximo de estudios</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <div class="select is-info">
                                <select v-model="form.studies_level_2">
                                    <option value="0">No cuenta con escolaridad</option>
                                    <option value="1">Preescolar</option>
                                    <option value="2">Primaria</option>
                                    <option value="3">Secundaria</option>
                                    <option value="4">Preparatoria</option>
                                    <option value="5">Licenciatura</option>
                                    <option value="6">Posgrado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Ocupación</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input type="text" class="input" placeholder="Ocupación del padre, madre o tutor" v-model="form.occupation_2">
                        </p>
                        <span class="help is-danger" v-if="form.errors.has('occupation_2')" v-text="form.errors.get('occupation_2')"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address -->
        <p class="title is-6">Dirección de la persona que requiere el servicio</p>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Calle</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Calle" v-model="form.street_name">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('street_name')" v-text="form.errors.get('street_name')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Números</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Número exterior" v-model="form.external_number">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('external_number')" v-text="form.errors.get('external_number')"></span>
                </div>
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Número interior" v-model="form.internal_number">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('internal_number')" v-text="form.errors.get('internal_number')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Colonia</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Colonia" v-model="form.neighborhood">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('neighborhood')" v-text="form.errors.get('neighborhood')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Código postal</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Código postal" v-model="form.postal_code">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('postal_code')" v-text="form.errors.get('postal_code')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Alcaldía/Municipio</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Alcaldía/Municipio" v-model="form.municipality">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('municipality')" v-text="form.errors.get('municipality')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Entidad federativa</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Entidad federativa" v-model="form.state">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('state')" v-text="form.errors.get('state')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Teléfonos</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Teléfono de casa" v-model="form.house_phone">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('house_phone')" v-text="form.errors.get('house_phone')"></span>
                </div>
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Teléfono celular" v-model="form.cell_phone">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('cell_phone')" v-text="form.errors.get('cell_phone')"></span>
                </div>
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Teléfono de trabajo" v-model="form.work_phone">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('work_phone')" v-text="form.errors.get('work_phone')"></span>
                </div>
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Extensión" v-model="form.work_phone_ext">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('work_phone_ext')" v-text="form.errors.get('work_phone_ext')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Correo electrónico</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="email" class="input" placeholder="Correo electrónico" v-model="form.email">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
                </div>
            </div>
        </div>
        
        <!-- socio-economic situation -->
        <p class="title is-6">Situación socioeconómica</p>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Escolaridad</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <div class="select is-info">
                            <select v-model="form.scholarship">
                                <option value="0">No cuenta con escolaridad</option>
                                <option value="1">Preescolar</option>
                                <option value="2">Primaria</option>
                                <option value="3">Secundaria</option>
                                <option value="4">Preparatoria</option>
                                <option value="5">Licenciatura</option>
                                <option value="6">Posgrado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <label-select v-model="form.studied_years" :items="['1', '2', '3', '4', '5', '6 o más']">
                    Años concluidos de estudio
                </label-select>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">¿Trabaja actualmente?</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input type="checkbox" v-model="form.has_work">
                    </div>
                </div>
            </div>
        </div>
        <div v-if="form.has_work">
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">¿Recibe remuneración económica por su trabajo?</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">
                            <input type="checkbox" v-model="form.has_salary">
                        </div>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Descripción de su trabajo</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input type="text" class="input" placeholder="Descripción de su trabajo" v-model="form.work_description">
                        </p>
                        <span class="help is-danger" v-if="form.errors.has('work_description')" v-text="form.errors.get('work_description')"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Número de integrantes del hogar (contando la persona que requiere el servicio)</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="number" class="input" placeholder="Número de integrantes del hogar" v-model="form.household_members">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('household_members')" v-text="form.errors.get('household_members')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Ingreso familiar mensual</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="number" class="input" placeholder="Ingreso familiar mensual" v-model="form.monthly_family_income">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('monthly_family_income')" v-text="form.errors.get('monthly_family_income')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Número de personas que aportan a este ingreso (contando la persona que requiere el servicio)</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="number" class="input" placeholder="Número de personas que aportan a este ingreso" v-model="form.number_people_contributing">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('number_people_contributing')" v-text="form.errors.get('number_people_contributing')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Número de personas que dependen de este ingreso (contando la persona que requiere el servicio)</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="number" class="input" placeholder="Número de personas que dependen de este ingreso" v-model="form.number_people_depending">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('number_people_depending')" v-text="form.errors.get('number_people_depending')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Su casa es:</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <div class="select is-info">
                            <select v-model="form.house_is">
                                <option value="0">Otra</option>
                                <option value="1">Propia</option>
                                <option value="2">Propia, pero la está pagando</option>
                                <option value="3">Rentada</option>
                                <option value="4">Prestada</option>
                                <option value="5">Intenstada o en litigio</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- about service -->
        <p class="title is-6">Servicio solicitado</p>
        <label-select v-model="form.service_type" :items="['Orientación/Consejo breve', 'Evaluación', 'Intervención']">
            Servicio solicitado           
        </label-select>
        <label-select v-model="form.service_modality" :items="['Individual/Grupal', 'Familiar/Pareja']">
            Modalidad de servicio que solicita            
        </label-select>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Motivo de consulta (Describa de forma detallada lo que le pasa y qué espera de la atención que se le puede brindar en este Centro/Programa)</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <textarea class="textarea" placeholder="Motivo de consulta" v-model="form.consultation_cause"></textarea>
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('consultation_cause')" v-text="form.errors.get('consultation_cause')"></span>
                </div>
            </div>
        </div>
        <label-select v-model="form.mhGAP_cause_classification" :items="['Depresión', 'Psicosis', 'Epilepsia', 'Transtornos mentales y conductuales del niño y el adolescente', 'Demencia', 'Transtornos por el consumo de sustancias', 'Autolesión/Suicidio', 'Otros padecimientos de salud importantes']">
            Clasificación del motivo de consulta según la guía mhGAP            
        </label-select>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">¿Desde cuándo le pasa esto?</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="¿Desde cuándo le pasa esto?" v-model="form.problem_since">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('problem_since')" v-text="form.errors.get('problem_since')"></span>
                </div>
            </div>
        </div>
        <label-select v-model="form.has_recived_previous_treatment" :items="['No', 'Si']">
            ¿Ha recibido anteriormente tratamiento para dar solución a esta situación?            
        </label-select>
        <div class="field is-horizontal" v-if="form.has_recived_previous_treatment">
            <div class="field-label">
                <label class="label">Número de veces que ha sido atendido para esta situación</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="number" class="input" placeholder="Número de veces que ha sido atendido para esta situación" v-model="form.number_times_treatment">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('number_times_treatment')" v-text="form.errors.get('number_times_treatment')"></span>
                </div>
            </div>
        </div>
        <label-select v-if="form.has_recived_previous_treatment" v-model="form.type_previous_treatment" :items="['Psicológica', 'Psiquiátrica', 'Médica', 'Neurológica', 'Otra']">
            Tipo de atención que ha recibido            
        </label-select>
        <label-select v-model="form.refer" :items="['No', 'Escuela', 'Trabajo', 'Hospital/Instituto', 'Dpto. de Psiquiatría y Salud Mental (Fac. Medicina)']">
            ¿Viene referido de otra institución?          
        </label-select>
        <div class="field is-horizontal" v-if="form.refer">
            <div class="field-label">
                <label class="label">Problemática referido de la institución</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <p class="control">
                        <input type="text" class="input" placeholder="Problemática referido de la institución" v-model="form.refer_problem">
                    </p>
                    <span class="help is-danger" v-if="form.errors.has('refer_problem')" v-text="form.errors.get('refer_problem')"></span>
                </div>
            </div>
        </div>
        <label-select v-model="form.unam_previous_treatment" :items="['No', 'Si']">
            ¿Ha recibido atención en otros Centros y/o Programas de la facultad para su motivo de consulta?          
        </label-select>
        <label-select v-if="form.unam_previous_treatment" v-model="form.unam_previous_treatment_program" :items="['CSPGD', 'CCJM', 'CPAHAV', 'CISEE', 'PAPD', 'PROSEXHUM', 'Programa de conductas adictivas', 'CCLV']">
            Centro/Programa          
        </label-select>
        <label-select v-model="form.has_health_issue" :items="['No', 'Si']">
            ¿Tiene algún problema de salud?          
        </label-select>
        <div v-if="form.has_health_issue">
            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">¿Cuál?</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input type="text" class="input" placeholder="Problema de salud" v-model="form.health_issue">
                        </p>
                        <span class="help is-danger" v-if="form.errors.has('health_issue')" v-text="form.errors.get('health_issue')"></span>
                    </div>
                </div>
            </div>
            <label-select v-model="form.takes_medication" :items="['No', 'Si']">
                ¿Toma medicamentos?          
            </label-select>
            <div class="field is-horizontal" v-if="form.takes_medication">
                <div class="field-label">
                    <label class="label">¿Cuál(es)?</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input type="text" class="input" placeholder="Medicamentos" v-model="form.medication">
                        </p>
                        <span class="help is-danger" v-if="form.errors.has('medication')" v-text="form.errors.get('medication')"></span>
                    </div>
                </div>
            </div>
            <div class="field is-horizontal" v-if="form.takes_medication">
                <div class="field-label">
                    <label class="label">Dosis</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input type="text" class="input" placeholder="Dosis" v-model="form.medication_dose">
                        </p>
                        <span class="help is-danger" v-if="form.errors.has('medication_dose')" v-text="form.errors.get('medication_dose')"></span>
                    </div>
                </div>
            </div>
        </div>
        <label-select v-model="form.prefer_time" :items="['Matutino', 'Vespertino', 'Indiferente']">
            Horario de preferencia     
        </label-select>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Centro/Programa en el que será atendido</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <div class="select is-info">
                            <select v-model="form.program">
                                <option v-for="program in programs" :key="program.id_centro" :value="program.id_centro">{{ program.nombre }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- about service -->
        <p class="title is-6">Cita</p>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Fecha</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input type="date" class="date" v-model="form.appointment_date">
                    </div>
                    <span class="help is-danger" v-if="form.errors.has('appointment_date')" v-text="form.errors.get('appointment_date')"></span>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label">
                <label class="label">Hora</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input type="time" class="time" v-model="form.appointment_time">
                    </div>
                    <span class="help is-danger" v-if="form.errors.has('appointment_time')" v-text="form.errors.get('appointment_time')"></span>
                </div>
            </div>
        </div>
        <label-select  :items="['suup1', 'Sup 2', 'sup 3']">
            Supervisor     
        </label-select>


        <div class="field">
            <div class="control">
                <button class="button is-info" :disabled="form.errors.any()" >Registrar</button>
            </div>
        </div>
    </form>
</template>

<script>
import LabelSelect from './LabelSelect';

function isDate18orMoreYearsOld(dateString) {
    let year = parseInt(dateString.substring(0, 4));
    let month = parseInt(dateString.substring(5, 7));
    let day = dateString.substring(8, 11);
    let newDate = new Date(year+18, month-1, day)
    return newDate <= new Date();
}

export default {
    components: {
        LabelSelect
    },
    props:['url', 'programs'],
    data() {
        return {
            is_under_18: false,
            second_tutor: false,
            form: new Form({
                name: '',
                last_name: '',
                mothers_name: '',
                curp: '',
                gender: 0,
                birthdate: '',
                marital_status: 0,
                is_unam: 0,
                academic_entity: '',
                position: 0,
                career: '',
                semester: '',
                person_requesting: 0,
                name_requester: '',
                // tutors
                tutor_name_1: '',
                relationship_1: 0,
                tutor_birthdate_1: '',
                studies_level_1: 0,
                occupation_1: '',
                tutor_name_2: '',
                relationship_2: 0,
                tutor_birthdate_2: '',
                studies_level_2: 0,
                occupation_2: '',
                // address
                street_name: '',
                external_number: '',
                internal_number: '',
                neighborhood: '',
                postal_code: '',
                municipality: '',
                state: '',
                house_phone: '',
                cell_phone: '',
                work_phone: '',
                work_phone_ext: '',
                email: '',
                // socio-economic situation
                scholarship: 0,
                studied_years: 0,
                has_work: 0,
                has_salary: 0,
                work_description: '',
                household_members: '',
                monthly_family_income: '',
                number_people_contributing: '',
                number_people_depending: '',
                house_is: 0,
                // about the service
                service_type: 0,
                service_modality: 0,
                consultation_cause: '',
                mhGAP_cause_classification: 0,
                problem_since: '',
                has_recived_previous_treatment: 0,
                number_times_treatment: '',
                type_previous_treatment: 0,
                refer: 0,
                refer_problem: '',
                unam_previous_treatment: 0,
                unam_previous_treatment_program: null,
                has_health_issue: 0,
                health_issue: '',
                takes_medication: 0,
                medication: '',
                medication_dose: '',
                prefer_time: 0,
                program: 2,
                // appointment
                appointment_date: '',
                appointment_time: '',
                supervisor: 1
            })
        }
    },
    methods: {
        onSubmit() {
            this.form.post(this.url).then(function(response) {
                window.location = this.url;
                // console.log(response);
            });
        },
        checkIfOver18() {
            if (isDate18orMoreYearsOld(this.form.birthdate)) {
                this.is_under_18 = false;
            } else {
                this.is_under_18 = true;
            }
        },
        showSecondTutor() {
            this.second_tutor = true;
        }
    }
}
</script>
