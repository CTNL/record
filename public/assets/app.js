// Vuex Store

const store = new Vuex.Store({
  state: {
    records: [],
    credentials: []
  },
  mutations: {
    add (state, record) {
      state.records.push({
        id: Math.random().toString().split('.')[1],
        name: record.name,
        text: record.text,
        active: true
      });
    },
    fetch (state){
      Vue.http.get('/api/records') // does a HTTP GET request
        .then(function(response) {
          state.records = response.body // pushes the JSON parsed body to the data
        })
    },
    getToken (state){
      Vue.http.get('/api/token') // does a HTTP GET request
        .then(function(response) {
          if(response.body.result === 'success'){
            store.commit('login', response.body);
            router.push('/list');
          }
        })
      
    },
    update (state, record) {
      state.records[findRecordKey(record.id)] = {
        id: record.id,
        name: record.name,
        text: record.text,
        active: record.active
      }
    },
    delete (state, recordId) {
      state.records.splice(findRecordKey(recordId), 1)
    },
    login (state, credentials) {
      state.credentials = credentials;
      app.login = credentials.id;
      store.commit('fetch');
    },
    logout (state) {
      state.credentials = [];
      app.login = false;
    }
  },
  getters: {
    activeRecords (state) {
      return state.records.filter(function (record) {
        return record.active;
      },this);
    },
    totalLength (state, getters) {
      return getters.activeRecords
      .map(function (record) {return record.text.length})
      .reduce(function(a,b){ return a+b }, 0);
    }
  }
});

store.commit('getToken');


// Application

const charLimit = 2000;

function findRecord (recordId) {
  return store.state.records[findRecordKey(recordId)];
};

function findRecordKey (recordId) {
  for (var key = 0; key < store.state.records.length; key++) {
    if (store.state.records[key].id == recordId) {
      return key;
    }
  }
};

Vue.filter('truncate', function (text, stop, clamp) {
    return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '')
})

Vue.component('spinner', {
  name: 'spinner',
  props: {
    'message': {
      type: String,
      default: 'Loading...'
    }
  },
  data () {
    return {
    }
  },
  methods: {
  },
  template: '#spinner-template'
});

// Routers

var Login = Vue.extend({
  template: "#record-login",
  data: function () {
    return {
      credentials: {
        username: '',
        password: ''
      },
      loggingIn: false,
      error: ''
    }
  },
  mounted: function () {
    if(store.state.credentials.id) router.push('/list')
  },
  methods: {
    submit () {
      this.loggingIn = true;
      self = this;
      const credentials = {
        username: this.credentials.username,
        password: this.credentials.password
      };
      Vue.http.post('/api/login', credentials) // does a HTTP GET request
        .then(function(response) {
          self.loggingIn = false;
          if(response.body.result === 'success'){
            store.commit('login', response.body);
            router.push('/list');
          }
          else
            self.error = 'Incorrect Student Id or Password!';
        })
    }
  }
});

var List = Vue.extend({
  template: '#record-list',
  data: function () {
    return {records: store.state.records, searchKey: '', charLimit: charLimit};
  },
  computed: {
    filteredRecords: function () {
      return store.state.records.filter(function (record) {
        return this.searchKey=='' || record.name.toLocaleLowerCase().indexOf(this.searchKey.toLocaleLowerCase()) !== -1;
      },this);
    },
    activeRecords: function () {
      return store.getters.activeRecords
    },
    totalLength: function () {
      return store.getters.totalLength
    }
  },
  methods: {
    testThis: function () {
      store.commit('add', {name:"Yigit",text:"Hello world world world world world world world!"})
    }
  }
});

var Preview = Vue.extend({
  template: '#record-preview',
  data: function () {
    return {charLimit: charLimit};
  },
  computed: {
    activeRecords: function () {
      return store.getters.activeRecords
    },
    totalLength: function () {
      return store.getters.totalLength
    }
  }
});

var Record = Vue.extend({
  template: '#record',
  data: function () {
    return {record: findRecord(this.$route.params.record_id)};
  }
});

var RecordEdit = Vue.extend({
  template: '#record-edit',
  data: function () {
    return {record: findRecord(this.$route.params.record_id)};
  },
  methods: {
    updateRecord: function () {
      store.commit("update", this.record);
      router.push('/');
    }
  }
});

var RecordDelete = Vue.extend({
  template: '#record-delete',
  data: function () {
    return {record: findRecord(this.$route.params.record_id)};
  },
  methods: {
    deleteRecord: function () {
      store.commit("delete",this.$route.params.record_id);
      router.push('/');
    }
  }
});

var AddRecord = Vue.extend({
  template: '#add-record',
  data: function () {
    return {record: {name: '', text: '', active: true}}
  },
  methods: {
    createRecord: function() {
      store.commit("add", this.record);
      router.push('/');
    }
  }
});


// Vue Router

var router = new VueRouter({routes:[
  { path: '/', component: Login},
  { path: '/list', component: List},
  { path: '/preview', component: Preview},
  { path: '/record/:record_id', component: Record, name: 'record'},
  { path: '/add-record', component: AddRecord},
  { path: '/record/:record_id/edit', component: RecordEdit, name: 'record-edit'},
  { path: '/record/:record_id/delete', component: RecordDelete, name: 'record-delete'}
]});

router.beforeEach((to, from, next) => {
  if(to.path == '/')
  {
    if(store.state.credentials.id) router.push('/list');
    else next();
  } 
  else
  {
    if(store.state.credentials.id) next();
    else router.push('/');
  }
})

app = new Vue({
  router:router,
  data: {
    login: false
  },
  methods: {
    logout: function(){
      Vue.http.get('/api/logout');
      store.commit('logout');
      router.push('/');
    }
  }
}).$mount('#app')