<template>
  <div>
    <o-modal v-model:active="confirmDeleteActive">
      <div class="p-4">
        <p>¿Seguro que desea borrar este registro?</p>
      </div>
      <div class="flex flex-row-reverse gap-2 p-3 bg-gray-400">
        <o-button variant="danger" @click="deletePost()">Confirmar</o-button>
        <o-button @click="confirmDeleteActive = false">Cancelar</o-button>
      </div>
    </o-modal>
    <h1 class="text-center">Listado de Post</h1>
    <o-button icon-left="plus" @click="$router.push({ name: 'save' })"
      >Crear Post</o-button
    >
    <div class="mb-5"></div>
    <o-table
      :loading="isloading"
      :data="posts.current_page && posts.data.length == 0 ? [] : posts.data"
    >
      <o-table-column field="id" label="ID" numeric v-slot="p">
        {{ p.row.id }}
      </o-table-column>
      <o-table-column field="title" label="Titulo" v-slot="p">
        {{ p.row.title }}
      </o-table-column>
      <o-table-column field="posted" label="Posteado" v-slot="p">
        {{ p.row.posted }}
      </o-table-column>
      <o-table-column field="created_at" label="Fecha" v-slot="p">
        {{ p.row.created_at }}
      </o-table-column>
      <o-table-column field="category" label="Categoría" v-slot="p">
        {{ p.row.category.title }}
      </o-table-column>
      <o-table-column field="slug" label="Acciones" v-slot="p">
        <router-link
          class="mr-3"
          :to="{ name: 'save', params: { slug: p.row.slug } }"
        >
          Editar
        </router-link>
        <o-button
          icon-left="delete"
          :rounded="true"
          size="small"
          variant="danger"
          @click="
            deletePostRow = p;
            confirmDeleteActive = true;
          "
          >Eliminar</o-button
        >
      </o-table-column>
    </o-table>
    <br />
    <o-pagination
      v-if="posts.current_page && posts.data.length > 0"
      @change="updatePage"
      :total="posts.total"
      v-model:current="currentPage"
      :range-before="2"
      :range-after="2"
      order="centered"
      size="small"
      :simple="false"
      :rounded="true"
      :per-page="posts.per_page"
    >
    </o-pagination>
  </div>
</template>
<script>
export default {
  data() {
    return {
      posts: [],
      isloading: true,
      currentPage: 1,
      confirmDeleteActive: false,
      deletePostRow: "",
    };
  },
  methods: {
    updatePage() {
      setTimeout(this.listPage, 100);
    },

    listPage(p) {
      this.isloading = true;
      this.$axios.get("/api/post?page=" + this.currentPage).then((res) => {
        this.posts = res.data;
        console.log(this.posts);
        this.isloading = false;
      });
    },
    deletePost() {
      this.confirmDeleteActive = false;
      this.posts.data.splice(this.deletePostRow.index, 1);
      this.$axios.delete("/api/post/" + this.deletePostRow.row.id);
      this.$oruga.notification.open({
        message: "Registro eliminado",
        variant: "success",
        rootClass: "toast-notification",
        duration: 4000,
        queue: true,
      });
    },
  },

  async mounted() {
    this.listPage();
  },
};
</script>
