import "remixicon/fonts/remixicon.css";
import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";

// init Swiper:
const swiper = new Swiper('.swiper', {
  // configure Swiper to use modules
  modules: [Navigation, Pagination],
});