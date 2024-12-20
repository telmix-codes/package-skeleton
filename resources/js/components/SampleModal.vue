<template>
    <b-modal v-model="localIsVisible" :title="modalTitle" @hide="closeModal" size="lg">
        <div class="d-flex justify-content-end">
            <p>* = Required</p>
        </div>
        <b-form>
            <b-row>
                <b-col md="12">
                    <b-form-group label="UUID" label-for="input-uuid">
                        <b-form-input id="input-uuid" v-model="formData.uuid" required></b-form-input>
                    </b-form-group>

                    <b-form-group label="Name *" label-for="input-name">
                        <b-form-input id="input-name" v-model="formData.name" required :state="nameState"></b-form-input>
                        <b-form-invalid-feedback id="input-name-feedback">
                            This field is required
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-form-group label="Description" label-for="input-description">
                        <b-form-textarea
                            id="input-description"
                            v-model="formData.description"
                            placeholder="Enter description..."
                            rows="3"
                            max-rows="6"
                        ></b-form-textarea>
                    </b-form-group>

                    <b-form-group label="Code *" label-for="input-code">
                        <b-form-input id="input-code" v-model="formData.code" required :state="codeState"></b-form-input>
                        <b-form-invalid-feedback id="input-code-feedback">
                            This field is required
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-form-group label="Status" label-for="input-status">
                        <multiselect 
                            v-model="formData.status"
                            :options="statusOptions"
                            label="text"
                            track-by="value"
                            placeholder="Type to search"
                            open-direction="bottom"
                            :multiple="false"
                            :searchable="true"
                            class="mb-2"
                            style="height: 36px !important;"
                        />
                        <!-- <b-form-select v-model="formData.status" :options="statusOptions" id="input-status"></b-form-select> -->
                    </b-form-group>
                </b-col>
            </b-row>
        </b-form>
        <template #modal-footer>
            <b-button
                class="mr-3 float-right"
                variant="outline-secondary"
                @click="$emit('update:is-visible', false)"
            >
                CANCEL
            </b-button>
            <b-button
                variant="primary"
                @click="submitForm"
                :disabled="isSaveDisabled"
            >
                SAVE
            </b-button>
        </template>
    </b-modal>
</template>

<script>
export default {
    props: {
        isVisible: {
            type: Boolean,
            default: false
        },
        sampleData: {
            type: Object,
            required: true
        },
        modalTitle: {
            type: String,
            default: 'Enter Information'
        }
    },
    data() {
        return {
            formData: {
                id: '',
                uuid: '',
                name: '',
                description: '',
                code: '',
                status: ''
            },
            statusOptions: [
                { value: 'ACTIVE', text: 'ACTIVE' },
                { value: 'INACTIVE', text: 'INACTIVE' }
            ]
        };
    },
    computed: {
        localIsVisible: {
            get() {
                return this.isVisible;
            },
            set(value) {
                this.$emit('update:isVisible', value);
            }
        },
        nameState() {
            return this.formData.name ? null : false;
        },
        codeState() {
            return this.formData.code ? null : false;
        },
        isSaveDisabled() {
            return !(
                this.formData.name &&
                this.formData.code
            );
        }
    },
    watch: {
        sampleData: {
            immediate: true,
            handler(newVal) {
                if (newVal) {
                    this.formData = { ...newVal };
                    this.formData.status = newVal.status === 'ACTIVE'
                        ? { value: 'ACTIVE', text: 'ACTIVE' }
                        : { value: 'INACTIVE', text: 'INACTIVE' };
                }
            }
        }
    },
    methods: {
        submitForm() {
            // Emit event with all data of form
            this.$emit('submit', this.formData);
        },
        closeModal() {
            this.$emit('update:isVisible', false);
        }
    }
};
</script>