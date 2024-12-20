import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import VModal from 'vue-js-modal';
import SampleListing from './components/SamplesListing.vue';
import SampleModal from './components/SampleModal.vue';
import { EllipsisMenu, VueMultiselect } from "SharedComponents";
Vue.use(VModal);
Vue.use(BootstrapVue);
Vue.component('EllipsisMenu', EllipsisMenu);
Vue.component('VueMultiselect', VueMultiselect);
new Vue({
  el: '#app-package-skeleton',
  components: { SampleListing, SampleModal },
  data: {
    filter: '',
    addError: {
      name: null,
      status: null,
    },
    action: 'Add',
    isModalVisible: false,
    selectedData: {}
  },
  methods: {
    reload() {
      this.$refs.listing.dataManager([{
        field: 'updated_at',
        direction: 'desc',
      }]);
    },
    handleSubmit(formData) {
      if (this.action === 'Add') {
        ProcessMaker.apiClient.post('admin/package-skeleton', {
          uuid: formData.uuid,
          name: formData.name,
          description: formData.description,
          code: formData.code,
          status: formData.status.value,
        })
          .then(() => {
            this.reload();
            this.hideModal();
            ProcessMaker.alert('Record successfully added', "success");
          })
          .catch((error) => {
            if (error.response.status === 422) {
              this.addError = error.response.data.errors;
            }
          })
          .finally(() => {
            this.submitted = false;
            this.hideModal();
          });
      } else {
        ProcessMaker.apiClient.patch(`admin/package-skeleton/${formData.id}`, {
          uuid: formData.uuid,
          name: formData.name,
          description: formData.description,
          code: formData.code,
          status: formData.status.value,
        })
          .then(() => {
            this.reload();
            this.hideModal();
            ProcessMaker.alert('Record successfully updated', "success");
          })
          .catch((error) => {
            if (error.response.status === 422) {
              this.addError = error.response.data.errors;
            }
          })
          .finally(() => {
            this.submitted = false;
            this.hideModal();
          });
      }
    },
    showModal() {
      this.isModalVisible = true;
    },
    hideModal() {
      this.selectedData = {
        id: '',
        uuid: '',
        name: '',
        description: '',
        code: '',
        status: '',
      };
      this.isModalVisible = false;
    },
    newRecord() {
      this.action = 'Add';
      this.selectedData = {
        id: '',
        uuid: '',
        name: '',
        description: '',
        code: '',
        status: '',
      };
      this.showModal();
    },
    editRecord(data) {
      this.action = 'Edit';
      this.selectedData = {
        id: data.id,
        uuid: data.uuid,
        name: data.name,
        description: data.description,
        code: data.code,
        status: data.status,
      };
      this.showModal();
    },
  },
  computed: {
    modalTitle() {
      return this.action === 'Add' ? 'Add Record' : 'Edit Record';
    }
  }
});
