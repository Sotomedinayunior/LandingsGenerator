<template>
    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
       <div class="flex justify-between">
        <div class="flex ">
            <img :src="landing.logo" :alt="landing.name" lazy="loading" class="w-10 h-10">
             <div class="flex">
                <h2 class="">{{ landing.name }}</h2>
                <p>{{`https:\\${landing.name}.com`}}</p>
             </div>
        </div>
        <TrashIcon />
       </div>
       <div class="flex justify-between">
        <ArrowsExpandIcon />
        <div class="flex">
            <div class="flex"><TruckIcon /> {{landing.vehicle.legth }}</div>
            <div class="flex"><BookOpenIcon /> {{landing.reservations.legth }}</div>
        </div>
       </div>
    </div>
  </template>
  
  <script>
  
  import {TrashIcon , ArrowsExpandIcon , TruckIcon , BookOpenIcon } from '@heroicons/vue/24/outline'
  export default {
    name: "CardLanding",
    props: {
      landing: {
        type: Object,
        required: true
      }
    },

  };
  </script>
  