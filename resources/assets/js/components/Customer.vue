<template>
    <div class="container-fluid pt-5">
  <v-card>
    <v-card-title>
      Customers Data
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="users"
      :search="search"
    >
      <template v-slot:items="props">
        <td>{{ props.item.name }}</td>
        <td class="text-xs-left">{{ props.item.email}}</td>
        <td class="text-xs-left">{{ props.item.type }}</td>
        <td class="text-xs-left">{{ props.item.created_at  }}</td>
      </template>
      <v-alert v-slot:no-results :value="true" color="error" icon="warning">
        Your search for "{{ search }}" found no results.
      </v-alert>
    </v-data-table>
  </v-card>
</div>
</template>

<script>

    export default {
        data(){
            return{
                users:[],
                search: '',
             headers: [
          {
            text: 'Name',
            align: 'left',
            sortable: true,
            value: 'name'
          },
          { text: 'Email', value: 'email' },
          { text: 'Type', value: 'type' },
          { text: 'Created At', value: 'created' }
    
        ]
            }
        },
        created(){
            this.loadCustomers();
        },
        methods: {
          loadCustomers(){
                    
                        axios.get('api/users').then(({data})=>(this.users = data));
                    
                }
        }
        
                
        };

</script>
