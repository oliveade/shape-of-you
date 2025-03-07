FROM ubuntu:latest

ARG USERNAME
ARG PASSWORD

# Install the necessary packages for openssh-server
RUN apt-get update -y && apt-get install -y openssh-server sudo

# Create the necessary directories for sshd
RUN mkdir /var/run/sshd

RUN sed -i 's/#PermitRootLogin without-password/PermitRootLogin yes/' /etc/ssh/sshd_config
# Disable password authentication
RUN sed -i 's/#PasswordAuthentication yes/PasswordAuthentication no/' /etc/ssh/sshd_config
# Activate key authentication
RUN sed -i 's/#PubkeyAuthentication yes/PubkeyAuthentication yes/' /etc/ssh/sshd_config

# Generate host keys
RUN ssh-keygen -A

# Create a new user
RUN useradd -ms /bin/bash $USERNAME

# Set the password for the new user
RUN echo "$USERNAME:$PASSWORD" | chpasswd

# Allow the new user to run sudo commands
RUN usermod -aG sudo $USERNAME

# Allow the new user to run sudo commands without a password
RUN echo "$USERNAME ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers

# Set the default shell for the new user
RUN chsh -s /bin/bash $USERNAME

EXPOSE 22

COPY ./entrypoint.sh /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

# Start the sshd service
CMD ["bash"]