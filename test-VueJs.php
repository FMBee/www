
<html>
 <head>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.5.15/dist/vue.js"></script>
<!--   <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
  
  <style type="text/css">
    #todo {
      min-height: 400px;
    }
    
    input:checked ~ span {
      text-decoration: line-through;
    }
  </style>
 </head>
 <body>
     <div id="todo">
      <h1>
      TODO
      </h1>
      <p>{{ remaining.length }} remaining todo</p>
      <form v-on:submit.prevent="add()">
        <input type="text" v-model="name" />
        <button type="submit">
          add
        </button>
        <button type="button" v-if="remaining.length > 0" v-on:click="allDone()">All done</button>
      </form>
      <ul>
        <li v-for="todo in todos">
          <label>
            <input type="checkbox" v-model="todo.done" />
            <span>{{ todo.name }}</span>
          </label>
          <button type="button" v-on:click="remove(todo)">
            &times;
          </button>
        </li>
      </ul>
    </div>
    
    <script type="text/javascript">
    
    var myList = new Vue({
    	  el: '#todo',
    	  data: {
    	    name: null,
    	    todos: []
    	  },
    	  methods: {
    	    add: function() {
    	      if (this.name === null) {
    	        return;
    	      }
    	      this.todos.push({
    	        name: this.name,
    	        done: false
    	      });
    	      this.name = null;
    	    },
    	    remove: function(todo) {
    	      this.todos.splice(this.todos.indexOf(todo), 1);
    	      this.name = todo.name;
    	    },
    	    allDone: function() {
    	      for (var i in this.todos) {
    	        this.todos[i].done = true;
    	      }
    	    }
    	  },
    	  computed: {
    	    remaining: function() {
    	      return this.todos.filter(function(todo) {
    	        return !todo.done;
    	      });
    	    }
    	  },
//     	  updated: function() {
//         	  alert('Yo!');
//     	  }
    	});

	myList.todos = [{name:'first', done:false}, {name:'deuze', done:true}];
	myList.name = 'test';
    	    
    </script>
    
 </body>
</html>