<template>
  <Layout>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-10 content-between w-full">
      <!-- Left Side: Cash on Hand and Remittance -->
      <div class="border border-gray-300 text-black overflow-hidden flex flex-col items-center w-full h-80">
        <div class="p-4 flex flex-col items-center w-full">
          <!-- Cash on Hand Section -->
          <div class="bg--50 w-full">
            <div class="">
              <label class="text-xl font-semibold">Cash On Hand</label>
            </div>
          </div>
          <div class="mt-1 w-full">
            <div class="flex flex-col items-center bg-white border border-green-400 sm:rounded-lg w-full py-4 mb-4 mt-4">
              <div class="p-6 flex flex-col items-center w-full">
                <div class="flex justify-between items-center w-full">
                  <div class="text-4xl leading-7 font-semibold">
                    <div class="    pb-1">
                      <div class="text-5xl font-bold">{{ amount }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex flex-row items-center justify-center w-full">
              <input v-if="showInput && !cashAdded" v-model="amount" type="number" class="border border-gray-300 rounded-md px-4 py-2 mr-2" placeholder="Enter amount" />
              <button v-if="showInput && !cashAdded" @click="addCash" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 w-full rounded-md mr-2">Add Cash</button>
              <button @click="remitToAdmin" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 w-full rounded-md">Remit To Admin</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Side: Remittance Logs Section -->
      <div class="border border-gray-300 text-black overflow-hidden flex flex-col items-center w-full">
        <div class="p-4 flex flex-col items-center w-full">
          <div class="bg--50 w-full">
            <div class="">
              <label class="text-xl font-semibold">Remittance Logs</label>
            </div>
          </div>
          <div class="mt-1 w-full overflow-y-auto"> <!-- Add overflow-y-auto to enable vertical scrolling if needed -->
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction Id</th>
                  <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                  <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(cashadmin, id) in paginatedCashadmins" :key="id">
                  <td class="px-6 py-4 whitespace-nowrap text-center">{{ cashadmin.id }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-center">{{ cashadmin.amount }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-center">{{ cashadmin.formatted_date }}</td>
                </tr>
              </tbody>
            </table>
            <!-- Pagination Controls -->
            <div class="mt-4">
              <div class="px-4 text-right text-s font-medium text-gray-500 uppercase tracking-wider">
                <button @click="prevPage" :disabled="pagination.currentPage === 1">Prev</button>
                <span> / </span>
                <button @click="nextPage" :disabled="pagination.currentPage === pagination.lastPage">Next</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <div class="mt-4 border border-gray-300 text-black overflow-hidden flex flex-col items-center w-full flex-grow">
        <div class="p-4 flex flex-col items-center w-full">
          <div class="bg--50 w-full">
            <div class="">
              <label class="text-xl font-semibold">Cash Flow Logs</label>
            </div>
          </div>
          <div class="mt-1 w-full">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction Id</th>
                  <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Inflow</th>
                  <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Outflow</th>
                  <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(cashlog, id) in cashlogs" :key="id">
                  <td class="px-6 py-4 whitespace-nowrap text-center">{{ cashlog.transactionId }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-center">{{ cashlog.inflow }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-center">{{ cashlog.outflow }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-center">{{ cashlog.formatted_date }}</td>
                </tr>
              </tbody>
            </table>
            <!-- Pagination Controls (if needed) -->
            <!-- <div class="mt-4">
              <div class="px-4 text-right text-s font-medium text-gray-500 uppercase tracking-wider">
                <button @click="prevPage" :disabled="pagination.currentPage === 1">Prev</button>
                <span> / </span>
                <button @click="nextPage" :disabled="pagination.currentPage === pagination.lastPage">Next</button>
              </div>
            </div> -->
          </div>
        </div>
      </div>
  </Layout>
</template>

<script>
import axios from 'axios';
import Layout from "../../../Layout/Layout.vue";

export default {
  components: {
    Layout,
  },
  data() {
    return {
      amount: 0,
      showInput: true,
      cashAdded: false,
      cashlogs: [],
      pagination: {
        currentPage: 1,
        lastPage: 1,
      },
      cashadmins: [],
      itemsPerPage:3 ,
    };
  },
  computed: {
    paginatedCashadmins() {
      const startIndex = (this.pagination.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return this.cashadmins.slice(startIndex, endIndex);
    },
  },
  methods: {
    getCash() {
      axios.get("/get-cash").then(({ data }) => {
        this.amount = data.amount;
      }).catch(error => {
        console.error("Error fetching cash amount:", error);
      });
    },

    addCash() {
      const { amount } = this;
      axios.post("/add-cash", { amount }).then(({ data }) => {
        this.cashlogs.push(data); 
        this.showInput = false;
        this.cashAdded = true;
      }).catch(error => {
        console.error("Error adding cash:", error);
      });
    },

    remitToAdmin() {
      const { amount } = this;
      axios.post("/save-to-admin", { amount }).then(() => {
        this.amount = 0;
        this.showInput = true;
        this.cashAdded = false;
      }).catch(error => {
        console.error("Error remitting to admin:", error);
      });
    },

    getCashLogs() {
      axios.post("/get-cashlogs").then(({ data }) => {
        console.log("Fetched cashlogs:", data);
        this.cashlogs = data; 
        // this.pagination = data.pagination;
      });
    },

    getCashadmins() {
      axios.post("/get-admins").then(({ data }) => {
        console.log("Fetched cashlogs:", data);
        this.cashadmins = data; 
        this.pagination.lastPage = Math.ceil(this.cashadmins.length / this.itemsPerPage);
      });
    },

    prevPage() {
      if (this.pagination.currentPage > 1) {
        this.pagination.currentPage--;
      }
    },

    nextPage() {
      if (this.pagination.currentPage < this.pagination.lastPage) {
        this.pagination.currentPage++;
      }
    },
  },

  mounted() {
    this.getCash();
    this.getCashLogs();
    this.getCashadmins();
  },
};
</script>
