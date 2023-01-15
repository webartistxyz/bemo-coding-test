<template>
  <div>
    <div class="board" v-if="board">
      <draggable
        draggable=".board__card"
        class="board__column"
        v-model="column.cards"
        v-for="(column, cIndex) in board.columns"
        :key="cIndex"
        :options="{ group: 'cards' }"
        @end="onEnd"
      >
        <div slot="header" class="board__column__header">
          <h4>{{ column.name }}</h4>

          <button @click="onColumnDelete(column.id)">X</button>
        </div>
        <div
          class="board__card"
          v-for="card in column.cards"
          :key="card.id"
          @click="openCardModal(card)"
        >
          <div class="board__header">
            {{ card["title"] }}
          </div>
        </div>
        <button
          class="board__add-card-button"
          @click="addCard(board.id, column.id)"
          slot="footer"
        >
          <span>+</span> <span>Add Card</span>
        </button>
      </draggable>

      <button class="board__add-column-button" @click="addColumn()">
        <span>+</span> <span>Add Column</span>
      </button>
    </div>

    <button class="btn__dump-db" @click="dumpDb()">Dump DB</button>

    <modal name="details-modal" @closed="onModalClose">
      <div class="details-modal" v-if="selectedCard">
        <div>
          <h4
            contenteditable
            @blur="(e) => (selectedCard.title = e.target.innerText)"
          >
            {{ selectedCard.title }}
          </h4>
        </div>
        <div
          class="details-modal__description"
          contenteditable
          @blur="(e) => (selectedCard.description = e.target.innerText)"
        >
          {{
            selectedCard.description
              ? selectedCard.description
              : "Add description here"
          }}
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import { generateSentence } from "../../utils/helpers";
import "vue-js-modal/dist/styles.css";

export default {
  components: {
    draggable,
  },
  data() {
    return {
      boardId: 1,
      cards: [],
      selectedCard: {},
      board: null,
    };
  },
  methods: {
    async onColumnDelete(columnId) {
      await axios.delete(`/api/board-columns/${columnId}`);
      this.loadBoard();
    },
    async loadBoard() {
      const { data } = await axios.get(`/api/boards/${this.boardId}`);
      this.board = data;
    },
    async createColumn() {
      await axios.post(`/api/board-columns`, {
        board_id: this.boardId,
        name: "New Board",
      });
      this.loadBoard();
    },
    onTitleChange() {},
    openCardModal(card) {
      this.selectedCard = card;
      this.$modal.show("details-modal");
    },
    closeCardModal() {
      this.$modal.hide("details-modal");
    },
    async addCard(boardId, columnId) {
      await axios.post(`/api/cards`, {
        board_id: boardId,
        board_column_id: columnId,
        title: "New card",
      });

      this.loadBoard();
    },
    addColumn() {
      this.createColumn();
    },
    async onEnd(event) {
      const updatePositionData = this.board.columns.map((column) =>
        column.cards.map((card, i) => ({
          board_column_id: column.id,
          card_id: card.id,
          position: parseInt(i) + 1,
        }))
      );

      console.log(updatePositionData);

      await axios.put(`/api/cards/update-positions`, {
        columns: updatePositionData,
      });
    },
    async dumpDb() {
      window.open(`/dump-db`, "_blank");
    },
    async onModalClose() {
      await axios.put(`/api/cards/${this.selectedCard.id}`, {
        ...this.selectedCard,
      });
    },
  },
  mounted() {
    this.loadBoard();
  },
};
</script>