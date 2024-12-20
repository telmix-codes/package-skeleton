<template>
  <div class="data-table">
    <vuetable
      :data-manager="dataManager"
      :sort-order="sortOrder"
      :css="css"
      :api-mode="false"
      :fields="fields"
      :data="data"
      data-path="data"
      pagination-path="meta"
      @vuetable:pagination-data="onPaginationData"
    >
      <template
        slot="actions"
        slot-scope="props"
      >
        <div class="actions">
          <ellipsis-menu
            :actions="actions"
            :data="props.rowData"
            :divider="true"
            @navigate="onNavigate"
          />
        </div>
      </template>
    </vuetable>
    <pagination
      ref="pagination"
      single="Record"
      plural="Records"
      :per-page-select-enabled="true"
      @changePerPage="changePerPage"
      @vuetable-pagination:change-page="onPageChange"
    />
  </div>
</template>

<script>
import datatableMixin from './common/mixins/datatable';

export default {
  mixins: [datatableMixin],
  props: ['filter'],

  data() {
    return {
      orderBy: 'id',
      // Our listing of samples
      sortOrder: [
        {
          field: 'id',
          sortField: 'id',
          direction: 'asc',
        },
      ],
      fields: [
      {
          title: 'ID',
          name: 'id',
          sortField: 'id',
        },
        {
          title: 'UUID',
          name: 'uuid',
          sortField: 'uuid',
        },
        {
          title: 'Name',
          name: 'name',
          sortField: 'name',
        },
        {
          title: 'Description',
          name: 'description',
          sortField: 'description',
        },
        {
          title: 'Code',
          name: 'code',
          sortField: 'code',
        },
        {
          title: 'Status',
          name: 'status',
          sortField: 'status',
          callback:(val) => this.formatStatus(val),
        },
        {
          title: 'Created at',
          name: 'created_at',
          sortField: 'created_at',
        },
        {
          name: '__slot:actions',
          title: '',
        },
      ],
      actions: [
        {
          value: "edit-item",
          content: "Edit",
          icon: "fas fa-pen-square",
        },
        {
          value: "delete-item",
          content: "Delete",
          icon: "fas fa-trash-alt",
        },
      ],
    };
  },
  methods: {
    formatStatus(status) {
      const stat = status.toLowerCase();
      const bubbleColor = {
        active: 'text-success',
        inactive: 'text-danger',
        draft: 'text-warning',
        archived: 'text-info',
      };
      return `<i class="fas fa-circle ${bubbleColor[stat]} small"></i> ${stat
        .charAt(0)
        .toUpperCase()}${stat.slice(1)}`;
    },
    fetch() {
      this.loading = true;
      // change method sort by sample
      this.orderBy = this.orderBy === 'id' ? 'id' : this.orderBy;
      // Load from our api client
      ProcessMaker.apiClient
        .get(
          `admin/package-skeleton/fetch?page=${this.page}&per_page=${this.perPage}&filter=${this.filter}&order_by=${this.orderBy}&order_direction=${this.orderDirection}`,
        )
        .then((response) => {
          this.data = this.transform(response.data);
          this.loading = false;
        });
    },
    onNavigate(action, data) {
      switch (action.value) {
        case 'edit-item':
          this.$parent.editRecord(data);
          break;
        case 'delete-item':
          ProcessMaker.confirmModal(
            'Caution!',
            `Are you sure to inactive the sample '${data.name}'?`,
            '',
            () => {
              ProcessMaker.apiClient.delete(`admin/package-skeleton/${data.id}`).then(() => {
                ProcessMaker.alert(`Record ${data.name} has been deleted`, 'warning');
                this.$emit('reload');
              });
            },
          );
          break;
        default:
          break;
      }
    },
  },
};
</script>

<style lang="scss" scoped></style>
