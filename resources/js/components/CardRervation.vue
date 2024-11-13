<template>
    <div class="card">
      <div class="card-header">
        <img :src="reservation.avatar_url || defaultAvatar" alt="Avatar" class="avatar" />
        <div class="card-info">
          <h3 class="name">{{ reservation.name_landing }}</h3>
          <p class="role">{{ reservation.name }}</p>
          <p class="location">
            <span class="icon-location"></span> {{ reservation.location }}
          </p>
        </div>
      </div>
      <div class="card-body">
        <p class="rating">
          <span class="icon-star"></span> {{ reservation.email }}
        </p>
        <!-- <p class="availability">
          <span class="icon-clock"></span> {{ reservation.phone }}
        </p> -->
        <button class="invite-button" @click="viewReservation">Ver</button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "CardReservation",
    props: {
      reservation: {
        type: Object,
        required: true,
      },
    },
    data() {
      return {
        defaultAvatar: "https://via.placeholder.com/150", // Imagen por defecto si no hay avatar
      };
    },
    methods: {
      viewReservation() {
        this.$emit("viewReservation", this.reservation);
      },
    },
  };
  </script>
  
  <style scoped>
  .card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    padding: 16px;
    margin: 16px;
    background-color: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 300px;
  }
  
  .card-header {
    display: flex;
    align-items: center;
    margin-bottom: 16px;
  }
  
  .avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin-right: 16px;
    border: 2px solid #ddd;
    object-fit: cover;
  }
  
  .card-info {
    flex-grow: 1;
  }
  
  .name {
    font-size: 18px;
    font-weight: bold;
    text-transform: capitalize;
    color: #333;
    margin: 0;
  }
  
  .role {
    font-size: 14px;
    color: #888;
    margin: 4px 0;
  }
  
  .location {
    font-size: 14px;
    color: #666;
    display: flex;
    align-items: center;
  }
  
  .icon-location {
    content: "📍";
    margin-right: 4px;
  }
  
  .card-body {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
  }
  
  .rating {
    font-size: 14px;
    color: #333;
    display: flex;
    align-items: center;
  }
  
  .icon-star {
    content: "⭐";
    margin-right: 4px;
  }
  
  .availability {
    font-size: 14px;
    color: #28a745;
    display: flex;
    align-items: center;
  }
  
  .icon-clock {
    content: "⏰";
    margin-right: 4px;
  }
  
  .invite-button {
    background-color: #f16822;
    color: #fff;
    border: none;
    border-radius: 20px;
    padding: 8px 16px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
  }
  
  .invite-button:hover {
    background-color: #c4551d;
  }
  </style>
  