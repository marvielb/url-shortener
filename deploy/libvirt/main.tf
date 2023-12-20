provider "libvirt" {
  uri = "qemu:///system"
}

resource "libvirt_volume" "debian-qcow2" {
    name = "debian-qcow2"
    source = var.debian_image_url
    format = "qcow2"
}

resource "libvirt_volume" "volume-main" {
  name = "volume-main"
  base_volume_id = "${libvirt_volume.debian-qcow2.id}"
  size=10000000000
}

resource "libvirt_volume" "volume-slave" {
  name = "volume-slave"
  base_volume_id = "${libvirt_volume.debian-qcow2.id}"
  size=10000000000
}

data "template_file" "user_data" {
  template = file("${path.module}/config/cloud_init.yml")
}

data "template_file" "network_config" {
  template = file("${path.module}/config/network_config.yml")
}

resource "libvirt_cloudinit_disk" "commoninit" {
  name           = "commoninit.iso"
  user_data      = data.template_file.user_data.rendered
  network_config = data.template_file.network_config.rendered
}

resource "libvirt_domain" "domain-debian" {
  name   = "Master Database"
  memory = "512"
  vcpu   = 1

  cloudinit = libvirt_cloudinit_disk.commoninit.id

  network_interface {
    network_name   = "default"
    wait_for_lease = true
    hostname       = var.vm_hostname
  }

  console {
    type        = "pty"
    target_port = "0"
    target_type = "serial"
  }

  console {
    type        = "pty"
    target_type = "virtio"
    target_port = "1"
  }

  disk {
    volume_id = libvirt_volume.volume-main.id
  }

  graphics {
    type        = "vnc"
  }
}


resource "libvirt_domain" "domain-debian-slave" {
  name   = "Slave Database"
  memory = "512"
  vcpu   = 1

  cloudinit = libvirt_cloudinit_disk.commoninit.id

  network_interface {
    network_name   = "default"
    wait_for_lease = true
    hostname       = var.vm_hostname
  }

  console {
    type        = "pty"
    target_port = "0"
    target_type = "serial"
  }

  console {
    type        = "pty"
    target_type = "virtio"
    target_port = "1"
  }

  disk {
    volume_id = libvirt_volume.volume-slave.id
  }

  graphics {
    type        = "vnc"
  }
}
